<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>https://{{ $_SERVER['HTTP_HOST'] }}</loc>
        <lastmod>2023-02-20</lastmod>
        <priority>1</priority>
    </url>

    @foreach($data as $key => $dataItem)
        @foreach($dataItem as $item)
            @if(isset($item->filter_url))
                <url>
                    <loc>https://{{ $_SERVER['HTTP_HOST'] }}/{{ $key }}/{{ $item->filter_url }}</loc>
                    <lastmod>{{ \Carbon\Carbon::now()->format('Y-m-d') }}</lastmod>
                    <priority>0.9</priority>
                </url>
            @endif
        @endforeach
    @endforeach

</urlset>
