<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($staticPages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    @foreach ($categories as $category)
    <url>
        <loc>{{ route('categories.show', $category->slug) }}</loc>
        <lastmod>{{ $category->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    @foreach ($products as $product)
    <url>
        <loc>{{ route('products.show', $product) }}</loc>
        <lastmod>{{ $product->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
