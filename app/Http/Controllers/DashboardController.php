<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function buyer(Request $request): View
    {
        $recentOrders = $request->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get();
        $totalOrders = $request->user()->orders()->where('status', '!=', 'cancelled')->count();
        $totalSpent = $request->user()->orders()->where('status', 'completed')->sum('grand_total');
        $completedOrders = $request->user()->orders()->where('status', 'completed')->count();

        return view('dashboard', compact('recentOrders', 'totalOrders', 'totalSpent', 'completedOrders'));
    }

    public function seller(): View
    {
        $sellerProfile = request()->user()->sellerProfile;
        abort_unless($sellerProfile, 403, 'Anda bukan seller.');

        $totalProducts = $sellerProfile->products()->count();
        $activeProducts = $sellerProfile->products()->where('status', 'active')->count();
        $paidStatuses = ['paid', 'shipped', 'completed'];
        $totalOrders = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereIn('status', $paidStatuses)->count();
        $todayRevenue = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereIn('status', $paidStatuses)
            ->whereDate('created_at', today())
            ->sum('subtotal');
        $monthRevenue = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereIn('status', $paidStatuses)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('subtotal');
        $totalRevenue = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereIn('status', $paidStatuses)
            ->sum('subtotal');
        $recentOrders = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->take(5)
            ->get();
        $topProducts = $sellerProfile->products()
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        $salesData = [];
        $dayLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = OrderItem::where('seller_profile_id', $sellerProfile->id)
                ->whereIn('status', $paidStatuses)
                ->whereDate('created_at', $date)
                ->sum('subtotal');
            $salesData[] = [
                'label' => $dayLabels[$date->dayOfWeek],
                'revenue' => (int) $revenue,
            ];
        }
        $maxRevenue = max(array_column($salesData, 'revenue')) ?: 1;

        $lowStockProducts = $sellerProfile->products()
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'sellerProfile',
            'totalProducts', 'activeProducts', 'totalOrders', 'totalRevenue',
            'todayRevenue', 'monthRevenue', 'recentOrders', 'topProducts',
            'salesData', 'maxRevenue', 'lowStockProducts'
        ));
    }

    public function admin(): View
    {
        $totalUsers = \App\Models\User::count();
        $totalSellers = SellerProfile::where('is_active', true)->count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalRevenue = OrderItem::where('status', 'completed')->sum('subtotal');
        $pendingVerifications = \App\Models\SellerVerification::where('status', 'pending')->count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $recentOrders = Order::with('user', 'items')->latest()->take(5)->get();

        // 30-day sales trend
        $salesData = [];
        $dayLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = OrderItem::where('status', 'completed')
                ->whereDate('updated_at', $date)
                ->sum('subtotal');
            $salesData[] = [
                'label' => $dayLabels[$date->dayOfWeek],
                'revenue' => (int) $revenue,
            ];
        }
        $maxRevenue = max(array_column($salesData, 'revenue')) ?: 1;

        // 30-day chart data for Chart.js
        $chartLabels = [];
        $chartRevenue = [];
        $chartOrders = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartRevenue[] = (int) Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->whereDate('created_at', $date)
                ->sum('grand_total');
            $chartOrders[] = Order::whereDate('created_at', $date)->count();
        }

        // Order status distribution
        $orderStatusData = Order::select('status', \DB::raw('count(*) as count'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Top categories by sales
        $topCategories = \App\Models\Category::select('categories.*')
            ->selectRaw('(SELECT COUNT(*) FROM products INNER JOIN order_items ON products.id = order_items.product_id WHERE products.category_id = categories.id AND order_items.status = ?) as sold_count', ['completed'])
            ->orderByDesc('sold_count')
            ->take(5)
            ->get()
            ->filter(fn ($c) => $c->sold_count > 0);

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders',
            'totalRevenue', 'pendingVerifications', 'recentUsers',
            'recentOrders', 'salesData', 'maxRevenue',
            'chartLabels', 'chartRevenue', 'chartOrders',
            'orderStatusData', 'topCategories'
        ));
    }
}
