<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Only allow admin to view logs
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé !');
        }

        $query = ActivityLog::with('user')->latest();

        // Search in logs
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('action', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
        }

        $logs = $query->paginate(20);

        return view('logs.index', compact('logs'));
    }
}
