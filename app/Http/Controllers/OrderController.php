<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // 1. نبينو جدول الطلبيات
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Order::latest();

        // إيلا كان موظف، كيشوف غير الماركة ديالو
        if ($user->role !== 'admin') {
            $query->where('brand_id', $user->brand_id);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                  ->orWhere('group_id', 'like', '%' . $searchTerm . '%');
            });
        }

        $orders = $query->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // 2. نبدلو الحالة ديال الطلب
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en attente,confirmé,expédié,livré,annulé',
        ]);

        $user = auth()->user();

        // 🛡️ الحماية 1: إيلا كان موظف وبغا يبدل كوموند ديال ماركة أخرى، نضربوه لليد!
        if ($user->role === 'employe' && $user->brand_id != $order->brand_id) {
            return redirect()->back()->with('error', '❌ Vous n\'avez pas le droit de modifier cette commande !');
        }

        // 🛡️ الحماية 2: الموظف ماعندوش الحق يرد الكوموند "مؤكدة" ولا "ملغية" (هادي خدمة الأدمن)
        if ($user->role === 'employe' && in_array($request->status, ['en attente', 'confirmé', 'annulé'])) {
            return redirect()->back()->with('error', '❌ Seul l\'administrateur peut confirmer ou annuler une commande !');
        }

        // --- كود الستوك لي ديجا درنا ---
        if ($request->status == 'livré' && $order->status != 'livré') {
            foreach($order->items as $id => $details) {
                $product = \App\Models\Product::find($id);
                if($product) {
                    $product->decrement('stock_quantity', $details['quantity']);
                }
            }
        }

        if ($request->status == 'annulé' && $order->status == 'livré') {
            foreach($order->items as $id => $details) {
                $product = \App\Models\Product::find($id);
                if($product) {
                    $product->increment('stock_quantity', $details['quantity']);
                }
            }
        }

        // كنحفظو الحالة الجديدة
        $order->status = $request->status;
        $order->save();

        ActivityLog::log("Modification Statut", "La commande CMD-{$order->id} est passée à : {$request->status}");

        return redirect()->back()->with('success', 'Statut mis à jour avec succès !');
    }

    // 3. صفحة تعديل الكوموند (تبديل الكمية أو حذف منتج)
    public function edit(Order $order)
    {
        $user = auth()->user();

        // الموظف ما يقدرش يعدل كوموند ديال ماركة أخرى
        if ($user->role === 'employe' && $user->brand_id != $order->brand_id) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé !');
        }

        // ما يقدرش يعدل كوموند لي ديجا توصلات
        if ($order->status === 'livré') {
            return redirect()->route('orders.index')->with('error', '❌ Impossible de modifier une commande déjà livrée.');
        }

        return view('orders.edit', compact('order'));
    }

    // 4. حفظ التعديلات ديال الكوموند
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();

        // حماية
        if ($user->role === 'employe' && $user->brand_id != $order->brand_id) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé !');
        }

        if ($order->status === 'livré') {
            return redirect()->route('orders.index')->with('error', '❌ Impossible de modifier une commande déjà livrée.');
        }

        $items = $order->items;
        $newItems = [];
        $newTotal = 0;

        foreach ($items as $id => $details) {
            $qty = (int) ($request->input("quantities.$id", 0));

            // إيلا الكمية 0 أو ما كايناش، كنحيدو المنتج من الكوموند
            if ($qty > 0) {
                $details['quantity'] = $qty;
                $newItems[$id] = $details;
                $newTotal += $details['price'] * $qty;
            }
        }

        // إيلا حيد كاع المنتجات، نمسحو الكوموند كاملة
        if (empty($newItems)) {
            $order->delete();
            return redirect()->route('orders.index')->with('success', '🗑️ Commande supprimée (tous les produits ont été retirés).');
        }

        $order->items = $newItems;
        $order->total = $newTotal;
        $order->save();

        ActivityLog::log("Modification Commande", "La commande CMD-{$order->id} a été modifiée (Quantités ou suppression de produits).");

        return redirect()->route('orders.index')->with('success', '✅ Commande #' . $order->id . ' modifiée avec succès !');
    }
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;
        $user = auth()->user();

        if (!$ids) return redirect()->back()->with('error', '❌ Sélectionnez des commandes.');

        $query = \App\Models\Order::whereIn('id', $ids);

        // 🛡️ حماية IDOR: الموظف يشوف غير الكوموندات ديال الماركة ديالو
        if ($user->role === 'employe') {
            $query->where('brand_id', $user->brand_id);
        }

        if ($action == 'delete') {
            // 🛡️ غير الأدمن يقدر يحذف
            if ($user->role !== 'admin') {
                return redirect()->back()->with('error', '❌ Seul l\'administrateur peut supprimer les commandes !');
            }
            $count = $query->count();
            $query->delete();
            ActivityLog::log("Suppression Massive", "{$count} commandes ont été supprimées.");
        } elseif ($action == 'confirm') {
            // 🛡️ غير الأدمن يقدر يأكد
            if ($user->role !== 'admin') {
                return redirect()->back()->with('error', '❌ Seul l\'administrateur peut confirmer les commandes !');
            }
            $count = $query->count();
            $query->update(['status' => 'confirmé']);
            ActivityLog::log("Confirmation Massive", "{$count} commandes ont été confirmées.");
        }

        return redirect()->back()->with('success', '✅ Opération réussie sur les commandes.');
    }

    // 5. طباعة  PDF
    public function invoice(Order $order)
    {
        $user = auth()->user();

        // 🛡️ حماية IDOR: الموظف ما يقدرش يطبع فاتورة ديال ماركة أخرى
        if ($user->role === 'employe' && $user->brand_id != $order->brand_id) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé : cette commande ne vous appartient pas !');
        }

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'facture-' . ($order->group_id ?? 'CMD-'.$order->id) . '.pdf';

        ActivityLog::log("Impression Facture", "La facture de la commande CMD-{$order->id} a été téléchargée.");

        return $pdf->download($filename);
    }

    // 6. Export Excel / CSV
    public function exportExcel(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Seul l\'administrateur peut exporter la liste globale.');
        }

        $orders = Order::latest()->get();

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=commandes_' . date('Y-m-d_H-i') . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM pour qu'Excel lise correctement les accents
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['ID Commande', 'Client', 'Téléphone', 'Adresse', 'Total (MAD)', 'Statut', 'Date Création'], ';');

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->group_id ?? 'CMD-' . $order->id,
                    $order->name,
                    $order->phone,
                    $order->address,
                    $order->total,
                    $order->status,
                    $order->created_at->format('Y-m-d H:i:s')
                ], ';');
            }
            fclose($file);
        };

        ActivityLog::log("Export CSV", "L'administrateur a exporté la liste des commandes en CSV.");

        return response()->stream($callback, 200, $headers);
    }
}
