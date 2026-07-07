<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->when($request->module, fn ($q) => $q->where('module', $request->module))
            ->when($request->action, fn ($q) => $q->where('action', $request->action))
            ->when($request->search, fn ($q) => $q->where('description', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(25);

        $modules = ActivityLog::distinct()->pluck('module');

        return view('admin.activity-logs.index', compact('logs', 'modules'));
    }
}
