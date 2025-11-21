@if($links and false)

    <div class="links d-flex">
        @foreach($links as $item)
            @if($item['text'])
                <a href="/{{ $item['to'] }}" class="link">{{ $item['text'] }}</a>
            @endif
        @endforeach
    </div>

@endif
