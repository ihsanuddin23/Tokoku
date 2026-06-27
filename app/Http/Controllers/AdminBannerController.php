<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminBannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::orderBy('order')->paginate(10);

        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:100'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'link'       => ['nullable', 'string', 'max:255'],
            'order'      => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('banners', 'public');
        } else {
            $validated['image_path'] = null;
        }
        $validated['is_active'] = $request->boolean('is_active', false);
        $validated['order'] = $validated['order'] ?? Banner::max('order') + 1;

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('status', 'banner-created');
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:100'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'link'       => ['nullable', 'string', 'max:255'],
            'order'      => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', false);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('status', 'banner-updated');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('status', 'banner-deleted');
    }
}
