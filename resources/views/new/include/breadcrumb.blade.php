@if(isset($breadMicro))
    {!! $breadMicro !!}
@endif

<nav class="breadcrumbs">
    <ul class="d-flex">
        <li>
            <a href="/">
                Главная
            </a>
        </li>

        @if(isset($breadCrumbItems))

            @foreach($breadCrumbItems as $key => $value)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $value }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="/{{ $key }}">
                            {{ $value }}
                        </a>
                    </li>
                @endif
            @endforeach

        @else

            <li class="breadcrumb-item">
                {{ mb_ucfirst(trim($meta['h1'])) }}
            </li>

        @endif

    </ul>
</nav>


