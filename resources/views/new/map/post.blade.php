<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">

    @php
        /* @var $posts \App\Models\Post[] */
    @endphp

    @if($posts)

        @foreach($posts as $post)

            <url>
                <loc>https://{{ $_SERVER['HTTP_HOST'] }}/{{ $post->national->filter_url }}/{{ $post->url }}</loc>
                <lastmod>{{ \Carbon\Carbon::parse($post->updated_at )->toDateString()}}</lastmod>
                <priority>0.8</priority>
            </url>

        @endforeach

    @endif

</urlset>
