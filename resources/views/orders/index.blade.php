<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #1a1828; }
        ::-webkit-scrollbar-thumb { background: rgba(232,197,71,0.3); border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(232,197,71,0.5); }

        /* Status pulse animation */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.85); }
        }
        .status-dot { animation: pulse-dot 2s ease-in-out infinite; }

        /* Row slide in animation */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .order-row { animation: slideIn 0.3s ease forwards; }

        /* Checkbox styling */
        input[type="checkbox"] {
            accent-color: #e8c547;
        }

        /* Select styling */
        select option {
            background: #1a1828;
            color: #fffffe;
        }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Bulk Actions Hidden Form --}}
    <form id="bulkForm" action="{{ route('orders.bulk') }}" method="POST">
        @csrf
    </form>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto p-4 md:p-8">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            @php
                $allOrders = $orders; // paginated
                $statuses = [
                    ['label' => 'Total', 'icon' => '📊', 'count' => $orders->total(), 'color' => '#a7a4c0', 'bg' => 'rgba(167,164,192,0.08)', 'border' => 'rgba(167,164,192,0.15)'],
                    ['label' => 'En attente', 'icon' => '⏳', 'count' => \App\Models\Order::where('status','en attente')->count(), 'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.08)', 'border' => 'rgba(251,191,36,0.18)'],
                    ['label' => 'Confirmé', 'icon' => '📞', 'count' => \App\Models\Order::where('status','confirmé')->count(), 'color' => '#60a5fa', 'bg' => 'rgba(96,165,250,0.08)', 'border' => 'rgba(96,165,250,0.18)'],
                    ['label' => 'Expédié', 'icon' => '🚚', 'count' => \App\Models\Order::where('status','expédié')->count(), 'color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.08)', 'border' => 'rgba(192,132,252,0.18)'],
                    ['label' => 'Livré', 'icon' => '✅', 'count' => \App\Models\Order::where('status','livré')->count(), 'color' => '#6ee7b7', 'bg' => 'rgba(110,231,183,0.08)', 'border' => 'rgba(110,231,183,0.18)'],
                ];
            @endphp
            @foreach($statuses as $stat)
                <div class="rounded-xl p-4 transition-all duration-300 hover:scale-[1.02]"
                     style="background:{{ $stat['bg'] }}; border:1px solid {{ $stat['border'] }};">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg">{{ $stat['icon'] }}</span>
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:{{ $stat['color'] }};">{{ $stat['label'] }}</span>
                    </div>
                    <div class="text-2xl font-bold" style="color:{{ $stat['color'] }}; font-family:'DM Serif Display',serif;">
                        {{ $stat['count'] }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Main Card --}}
        <div class="rounded-2xl p-6 md:p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Commandes
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        📦 Gestion des Commandes
                    </h2>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    <form action="{{ route('orders.index') }}" method="GET" class="flex gap-2 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Chercher (Nom, Tél, CMD...)"
                               class="w-full px-4 py-2 rounded-xl text-sm outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                        <button type="submit"
                                class="font-semibold px-4 py-2 rounded-xl text-sm transition-all duration-200"
                                style="background:rgba(255,255,255,0.1); color:#fffffe; border:1px solid rgba(255,255,255,0.1);"
                                onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            🔍
                        </button>
                    </form>
                    <a href="{{ route('shop.index') }}"
                       class="font-semibold text-sm transition-all duration-200 px-4 py-2 rounded-xl text-center w-full sm:w-auto"
                       style="color:#e8c547; background:rgba(232,197,71,0.08); border:1px solid rgba(232,197,71,0.15);"
                       onmouseover="this.style.background='rgba(232,197,71,0.15)'"
                       onmouseout="this.style.background='rgba(232,197,71,0.08)'">
                        ← Retour au site
                    </a>

                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('orders.export') }}"
                       class="font-semibold text-sm transition-all duration-200 px-4 py-2 rounded-xl text-center w-full sm:w-auto flex items-center justify-center gap-2"
                       style="color:#10b981; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2);"
                       onmouseover="this.style.background='rgba(16,185,129,0.15); this.style.transform=\'scale(1.02)\''"
                       onmouseout="this.style.background='rgba(16,185,129,0.1); this.style.transform=\'scale(1)\''">
                        📊 Exporter CSV / Excel
                    </a>
                    @endif
                </div>
            </div>

            {{-- Bulk Action Buttons --}}
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 mb-6 p-4 rounded-xl" style="background:#232136; border:1px solid rgba(255,255,255,0.05);">
                <div class="flex items-center justify-between w-full sm:w-auto mb-2 sm:mb-0">
                    <span class="text-xs font-semibold uppercase tracking-wider self-center mr-2" style="color:#6e6b8a;">Actions :</span>
                    <span id="selectedCount" class="text-xs font-medium self-center sm:hidden" style="color:#6e6b8a;">0 sélectionné(s)</span>
                </div>
                
                <button type="submit" form="bulkForm" name="action" value="confirm"
                        class="flex justify-center items-center gap-2 text-xs font-bold py-2 px-4 rounded-lg transition-all duration-200 w-full sm:w-auto"
                        style="background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.2);"
                        onmouseover="this.style.background='rgba(96,165,250,0.2)'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='rgba(96,165,250,0.1)'; this.style.transform='translateY(0)'">
                    📞 Confirmer la sélection
                </button>

                <button type="submit" form="bulkForm" name="action" value="delete"
                        onclick="return confirm('⚠️ Voulez-vous vraiment supprimer les commandes sélectionnées ?')"
                        class="flex justify-center items-center gap-2 text-xs font-bold py-2 px-4 rounded-lg transition-all duration-200 w-full sm:w-auto"
                        style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.transform='translateY(0)'">
                    🗑️ Supprimer la sélection
                </button>

                <span id="selectedCountDesk" class="hidden sm:inline text-xs font-medium self-center ml-auto" style="color:#6e6b8a;">
                    0 sélectionné(s)
                </span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-xl" style="border:1px solid rgba(255,255,255,0.07);">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr style="background:#232136;">
                            <th class="px-4 py-4">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 cursor-pointer rounded">
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">ID / Date</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">Client</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">Produits</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">Total</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">Statut</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold uppercase tracking-wider" style="color:#a7a4c0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        @php
                            // Status configuration
                            $statusConfig = [
                                'en attente' => ['color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.1)', 'border' => 'rgba(251,191,36,0.25)', 'icon' => '⏳', 'label' => 'En attente'],
                                'confirmé'   => ['color' => '#60a5fa', 'bg' => 'rgba(96,165,250,0.1)', 'border' => 'rgba(96,165,250,0.25)', 'icon' => '📞', 'label' => 'Confirmé'],
                                'expédié'    => ['color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.1)', 'border' => 'rgba(192,132,252,0.25)', 'icon' => '🚚', 'label' => 'Expédié'],
                                'livré'      => ['color' => '#6ee7b7', 'bg' => 'rgba(110,231,183,0.1)', 'border' => 'rgba(110,231,183,0.25)', 'icon' => '✅', 'label' => 'Livré'],
                                'annulé'     => ['color' => '#f87171', 'bg' => 'rgba(239,68,68,0.1)', 'border' => 'rgba(239,68,68,0.25)', 'icon' => '❌', 'label' => 'Annulé'],
                            ];
                            $sc = $statusConfig[$order->status] ?? $statusConfig['en attente'];
                        @endphp
                        <tr class="order-row"
                            style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s; animation-delay:{{ $index * 0.05 }}s;"
                            onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Checkbox --}}
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" form="bulkForm" name="ids[]" value="{{ $order->id }}" class="row-checkbox w-4 h-4 cursor-pointer rounded">
                            </td>

                            {{-- ID & Date --}}
                            <td class="px-5 py-4">
                                <div class="font-bold text-lg" style="color:#e8c547;">#{{ $order->id }}</div>
                                @if($order->group_id)
                                    <div class="mt-1">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded"
                                              style="background:rgba(255,255,255,0.06); color:#a7a4c0; border:1px dashed rgba(255,255,255,0.15);"
                                              title="Livraison groupée">
                                            🔗 {{ $order->group_id }}
                                        </span>
                                    </div>
                                @endif
                                <div class="text-xs mt-1.5" style="color:#6e6b8a;">
                                    {{ $order->created_at->format('d/m/Y') }}
                                    <span style="color:#4a4766;">•</span>
                                    {{ $order->created_at->format('H:i') }}
                                </div>
                            </td>

                            {{-- Client --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                         style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                                        {{ strtoupper(substr($order->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm" style="color:#fffffe;">{{ $order->name }}</div>
                                        <div class="text-xs mt-0.5" style="color:#a7a4c0;">📞 {{ $order->phone }}</div>
                                        <div class="text-xs mt-0.5 max-w-[180px] truncate" style="color:#6e6b8a;" title="{{ $order->address }}">
                                            📍 {{ $order->address }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Products --}}
                            <td class="px-5 py-4">
                                <div class="space-y-1 max-w-[250px]">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="font-bold px-1.5 py-0.5 rounded" style="background:rgba(232,197,71,0.08); color:#e8c547;">
                                                {{ $item['quantity'] }}x
                                            </span>
                                            <span class="truncate" style="color:#a7a4c0;">{{ $item['name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Total --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="font-bold text-lg" style="color:#fffffe;">
                                    {{ number_format($order->total, 2) }}
                                    <span class="text-xs font-semibold" style="color:#e8c547;">DH</span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                {{-- Status Badge --}}
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="status-dot w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $sc['color'] }};"></span>
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                          style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}; border:1px solid {{ $sc['border'] }};">
                                        {{ $sc['icon'] }} {{ $sc['label'] }}
                                    </span>
                                </div>

                                {{-- Status Change Form --}}
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex gap-1.5 items-center">
                                    @csrf
                                    @method('PUT')

                                    @if(auth()->user()->role === 'employe' && $order->status === 'en attente')
                                        <span class="text-xs font-semibold px-2 py-1 rounded"
                                              style="background:rgba(251,191,36,0.08); color:#fbbf24; border:1px solid rgba(251,191,36,0.15);">
                                            ⏳ Attente Admin
                                        </span>
                                    @else
                                        <select name="status"
                                                class="rounded-lg px-2 py-1.5 text-xs font-bold focus:outline-none cursor-pointer transition-all duration-200"
                                                style="background:#0f0e17; color:#fffffe; border:1px solid rgba(255,255,255,0.1);"
                                                onfocus="this.style.borderColor='#e8c547'"
                                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">

                                            @if(auth()->user()->role === 'admin')
                                                <option value="en attente" {{ $order->status == 'en attente' ? 'selected' : '' }}>⏳ En attente</option>
                                                <option value="confirmé" {{ $order->status == 'confirmé' ? 'selected' : '' }}>📞 Confirmé</option>
                                                <option value="expédié" {{ $order->status == 'expédié' ? 'selected' : '' }}>🚚 Expédié</option>
                                                <option value="livré" {{ $order->status == 'livré' ? 'selected' : '' }}>✅ Livré</option>
                                                <option value="annulé" {{ $order->status == 'annulé' ? 'selected' : '' }}>❌ Annulé</option>
                                            @endif

                                            @if(auth()->user()->role === 'employe')
                                                @if($order->status == 'confirmé')
                                                    <option value="confirmé" selected disabled>📞 Confirmé</option>
                                                @endif
                                                <option value="expédié" {{ $order->status == 'expédié' ? 'selected' : '' }}>🚚 Expédié</option>
                                                <option value="livré" {{ $order->status == 'livré' ? 'selected' : '' }}>✅ Livré</option>
                                            @endif
                                        </select>

                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                                                style="background:#e8c547; color:#0f0e17;"
                                                onmouseover="this.style.background='#f0d060'; this.style.transform='scale(1.05)'"
                                                onmouseout="this.style.background='#e8c547'; this.style.transform='scale(1)'">
                                            ✔
                                        </button>
                                    @endif
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    @if($order->status !== 'livré')
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 w-full justify-center"
                                           style="background:rgba(99,102,241,0.1); color:#818cf8; border:1px solid rgba(99,102,241,0.2);"
                                           onmouseover="this.style.background='rgba(99,102,241,0.2)'; this.style.transform='translateY(-1px)'"
                                           onmouseout="this.style.background='rgba(99,102,241,0.1)'; this.style.transform='translateY(0)'">
                                            ✏️ Modifier
                                        </a>
                                    @endif
                                    <a href="{{ route('orders.invoice', $order->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 w-full justify-center"
                                       style="background:rgba(232,197,71,0.1); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                                       onmouseover="this.style.background='rgba(232,197,71,0.2)'; this.style.transform='translateY(-1px)'"
                                       onmouseout="this.style.background='rgba(232,197,71,0.1)'; this.style.transform='translateY(0)'">
                                        📄 Facture
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Empty State --}}
            @if($orders->isEmpty())
                <div class="text-center py-20">
                    <div class="text-5xl mb-4">📭</div>
                    <p class="font-semibold text-lg" style="color:#a7a4c0;">Aucune commande pour le moment</p>
                    <p class="text-sm mt-2" style="color:#6e6b8a;">Les nouvelles commandes apparaîtront ici.</p>
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const countEl = document.getElementById('selectedCount');
            const countElDesk = document.getElementById('selectedCountDesk');

            function updateCount() {
                const checked = document.querySelectorAll('.row-checkbox:checked').length;
                const txt = checked + ' sélectionné(s)';
                if(countEl) countEl.textContent = txt;
                if(countElDesk) countElDesk.textContent = txt;
                const color = checked > 0 ? '#e8c547' : '#6e6b8a';
                if(countEl) countEl.style.color = color;
                if(countElDesk) countElDesk.style.color = color;
            }

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateCount();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) selectAll.checked = false;
                    if (document.querySelectorAll('.row-checkbox:checked').length === checkboxes.length) {
                        selectAll.checked = true;
                    }
                    updateCount();
                });
            });
        });
    </script>

</body>
</html>
