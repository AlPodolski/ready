@extends('new.layouts.main')
@section('title', $meta['title'])
@section('des', $meta['des'])

@if(isset($path) and $path)
    @section('can', $path)
@endif

@section('h1')
    <h1 class="big-red-text page-h1">{{ $meta['h1'] }}</h1>
@endsection

@section('filter')
    @include('new.include.filter')
@endsection

@section('location_metro')
    @include('new.include.location_metro')
@endsection

@section('links')
    @include('new.include.link')
@endsection

@php
$post = $posts->first();
@endphp

@if(isset($post->avatar))
    @section('preload_img')
        <link rel="preload" as="image" href="/thumbnail/600-800{{ $post->avatar }}" type="image/jpeg">
    @endsection
@endif

@section('content')

    @if(isset($productMicro))
        {!! $productMicro !!}
    @endif

    @if(isset($serviceMicro))
        {!! $serviceMicro !!}
    @endif

    @include('new.include.breadcrumb')

    <div class="row content">

        @php
            $i = 0;
            $review = false;
        @endphp

        @if($posts)
            @foreach($posts as $post)
                @include('new.include.item')
                @php
                    $i ++;
                    if ($post->reviews->first()){
                        $review = true;
                    }
                @endphp
            @endforeach
        @endif

    </div>

    @if($posts and $posts->total() > $posts->count())

        <div data-url="{{ str_replace('http', 'https', $posts->nextPageUrl()) }}" onclick="getMorePosts(this)"
             class="more-posts">Показать еще
        </div>

        {!! str_replace('http', 'https', $posts->links('vendor.pagination.bootstrap-4')) !!}
    @endif

@endsection


@section('open-graph')
    @include('new.include.open-graph', ['title' => $meta['title'], 'des' => $meta['des'], 'image' => '/images/logo.svg'])
@endsection
@section('catalog')
    @include('new.include.catalog-menu')
@endsection
