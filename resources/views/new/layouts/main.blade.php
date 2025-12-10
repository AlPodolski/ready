<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('des')">

    @if(View::hasSection('can'))
        <link rel="canonical" href="@yield('can')">
        <meta name="robots" content="index, follow">
    @endif

    @if(View::hasSection('open-graph'))
        @yield('open-graph')
    @endif
    <link rel="stylesheet" href="/fonts/ubuntu/ubuntu.css?v=1">
    <link rel="stylesheet" href="/css/style.css?v=1">

    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:description" content="@yield('des')"/>
    <meta property="og:url" content="{{ $_SERVER['REQUEST_URI'] }}"/>

    @hasSection('open_img')
        <meta property="og:image" content="@yield('open_img') "/>
    @else
        <meta property="og:image" content="/img/logo.svg"/>
    @endif

    @hasSection('preload_img')
        @yield('preload_img')
    @endif

    <meta property="og:site_name" content="sex-silk.com"/>
    <meta property="og:locale" content="ru_RU"/>

    <link rel="preconnect" href="https://mc.yandex.ru">

    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/favicon/site.webmanifest" />

</head>
<body>
    <header>
        <div class="container">
            <div class="row menu-logo-wrap">
                <a href="/" class="logo">
                    <img src="/images/logo.png" alt="">
                </a>
                <div class="menu-burger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="33" height="23" viewBox="0 0 33 23" fill="none">
                        <g clip-path="url(#clip0_19_170)">
                            <path d="M-0.70401 0.056633L4.09647 3.70463H27.9035L32.704 0.056633H-0.70401Z" fill="#CD82DD"/>
                            <path d="M27.9035 9.976H4.09647V13.624H27.9035V9.976Z" fill="#CD82DD"/>
                            <path d="M-0.70401 23.5434H32.704L27.9035 19.8954H4.09647L-0.70401 23.5434Z" fill="#CD82DD"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_19_170">
                                <rect width="33" height="23" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
<script defer src="/js/script.js?v=2"></script>
</body>
</html>
