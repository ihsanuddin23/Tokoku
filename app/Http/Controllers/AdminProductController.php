<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['sellerProfile', 'category'])
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function toggleStatus(Request $request, Product $product): RedirectResponse
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return back()->with('status', "Produk \"{$product->name}\" diubah ke {$newStatus}.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return back()->with('status', "Produk \"{$name}\" berhasil dihapus.");
    }

    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products-' . date('Y-m-d') . '.csv',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['ID', 'Nama', 'Kategori', 'Seller', 'Harga', 'Stok', 'Status', 'Rating', 'Total Terjual', 'Dibuat Pada']);

            Product::with(['category', 'sellerProfile'])->chunk(200, function ($products) use ($handle) {
                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->id,
                        $product->name,
                        $product->category?->name,
                        $product->sellerProfile?->store_name,
                        $product->price,
                        $product->stock,
                        $product->status,
                        $product->rating,
                        $product->total_sold,
                        $product->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
