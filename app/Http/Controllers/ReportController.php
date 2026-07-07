<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\SellerProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function sellerIndex(Request $request): View
    {
        $sellerProfile = $request->user()->sellerProfile;

        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orderItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereBetween('updated_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['order.user', 'product'])
            ->latest()
            ->get();

        $totalRevenue = $orderItems->where('status', 'completed')->sum('subtotal');
        $totalOrders = $orderItems->count();
        $totalCompleted = $orderItems->where('status', 'completed')->count();
        $totalPending = $orderItems->where('status', 'pending')->count();

        $topProducts = $sellerProfile->products()
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        return view('seller.reports.index', compact(
            'orderItems', 'totalRevenue', 'totalOrders', 'totalCompleted', 'totalPending',
            'topProducts', 'fromDate', 'toDate'
        ));
    }

    public function sellerExportPdf(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orderItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereBetween('updated_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['order.user', 'product'])
            ->latest()
            ->get();

        $totalRevenue = $orderItems->where('status', 'completed')->sum('subtotal');
        $topProducts = $sellerProfile->products()
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        $pdf = Pdf::loadView('seller.reports.pdf', compact(
            'orderItems', 'totalRevenue', 'topProducts', 'fromDate', 'toDate', 'sellerProfile'
        ));

        return $pdf->download('laporan-penjualan-' . $fromDate . '-' . $toDate . '.pdf');
    }

    public function sellerExportCsv(Request $request): StreamedResponse
    {
        $sellerProfile = $request->user()->sellerProfile;

        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orderItems = OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->whereBetween('updated_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['order.user', 'product'])
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-penjualan-' . $fromDate . '-' . $toDate . '.csv"',
        ];

        $columns = ['No. Pesanan', 'Produk', 'Pembeli', 'Qty', 'Subtotal', 'Status', 'Tanggal'];

        return response()->stream(function () use ($orderItems, $columns) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, $columns);
            foreach ($orderItems as $item) {
                fputcsv($handle, [
                    $item->order->order_number,
                    $item->product_name,
                    $item->order->user->name,
                    $item->quantity,
                    $item->subtotal,
                    $item->status,
                    $item->updated_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function adminIndex(Request $request): View
    {
        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['user', 'items'])
            ->latest()
            ->get();

        $totalRevenue = OrderItem::where('status', 'completed')
            ->whereBetween('updated_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->sum('subtotal');

        $totalOrders = $orders->count();
        $totalUsers = User::whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])->count();
        $totalSellers = SellerProfile::where('is_active', true)->count();

        $topProducts = Product::orderBy('total_sold', 'desc')->take(10)->get();

        return view('admin.reports.index', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalUsers', 'totalSellers',
            'topProducts', 'fromDate', 'toDate'
        ));
    }

    public function adminExportCsv(Request $request): StreamedResponse
    {
        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['user', 'items'])
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-admin-' . $fromDate . '-' . $toDate . '.csv"',
        ];

        $columns = ['No. Pesanan', 'Pembeli', 'Email', 'Subtotal', 'Ongkir', 'Diskon', 'Total', 'Status', 'Pembayaran', 'Tanggal'];

        return response()->stream(function () use ($orders, $columns) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, $columns);
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->subtotal,
                    $order->shipping_cost,
                    $order->discount_amount ?? 0,
                    $order->grand_total,
                    $order->status,
                    $order->payment_status,
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function adminExportPdf(Request $request)
    {
        $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->with(['user', 'items'])
            ->latest()
            ->get();

        $totalRevenue = OrderItem::where('status', 'completed')
            ->whereBetween('updated_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->sum('subtotal');

        $totalOrders = $orders->count();
        $totalUsers = User::whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])->count();
        $totalSellers = SellerProfile::where('is_active', true)->count();
        $topProducts = Product::orderBy('total_sold', 'desc')->take(10)->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalUsers', 'totalSellers', 'topProducts', 'fromDate', 'toDate'
        ));

        return $pdf->download('laporan-admin-' . $fromDate . '-' . $toDate . '.pdf');
    }
}
