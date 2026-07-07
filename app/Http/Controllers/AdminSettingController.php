<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string', 'max:100'],
            'settings.*.value' => ['nullable', 'string'],
            'settings.*.group' => ['required', 'string', 'max:50'],
        ]);

        foreach ($validated['settings'] as $item) {
            Setting::set($item['key'], $item['value'] ?? null, $item['group']);
        }

        Setting::flush();

        return redirect()->route('admin.settings.index')
            ->with('status', 'settings-updated');
    }
}
