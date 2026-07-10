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
        $recentOrders = Order::with('user:id,name', 'items:id,order_id,product_name,subtotal')->latest()->take(5)->get();

        // 30-day chart data — single query instead of 60
        $startDate = now()->subDays(29)->startOfDay();
        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(grand_total) as revenue, COUNT(*) as order_count')
            ->whereIn('status', ['paid', 'shipped', 'completed'])
            ->where('created_at', '>=', $startDate)
            ->groupByRaw('DATE(created_at)')
            ->pluck('revenue', 'date');

        $dailyOrders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as cnt')
            ->where('created_at', '>=', $startDate)
            ->groupByRaw('DATE(created_at)')
            ->pluck('cnt', 'date');

        $chartLabels = [];
        $chartRevenue = [];
        $chartOrders = [];
        $salesData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $revenue = (int) ($dailyRevenue[$dateKey] ?? 0);
            $chartLabels[] = $date->format('d M');
            $chartRevenue[] = $revenue;
            $chartOrders[] = (int) ($dailyOrders[$dateKey] ?? 0);
            $salesData[] = ['label' => $date->format('d M'), 'revenue' => $revenue];
        }
        $maxRevenue = max($chartRevenue) ?: 1;

        // Order status distribution — single query
        $orderStatusData = Order::select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Top categories — JOIN instead of correlated subquery
        $topCategories = \App\Models\Category::select('categories.id', 'categories.name')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as sold_count')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('order_items', function ($join) {
                $join->on('order_items.product_id', '=', 'products.id')
                    ->where('order_items.status', '=', 'completed');
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('sold_count')
            ->take(5)
            ->get()
            ->filter(fn ($c) => $c->sold_count > 0);

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders',
            'totalRevenue', 'pendingVerifications', 'recentUsers',
            'recentOrders',
            'chartLabels', 'chartRevenue', 'chartOrders',
            'salesData', 'maxRevenue',
            'orderStatusData', 'topCategories'
        ));
    }
}
