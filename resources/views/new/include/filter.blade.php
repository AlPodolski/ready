<div class="side-menu" id="filter">
    <form class="filter d-flex" id="filterPanel" action="/poisk">
        <div class="close-btn" id="filterClose">
            &times;
        </div>

        @if($data['metro']->first())

            <div class="form-item select position-relative">
                <select name="metro" id="metro">
                    <option value="">Метро</option>

                    @foreach($data['metro'] as $metroItem)
                        <option
                            @if(isset($dataSearch['metro']) and $dataSearch['metro'] and $dataSearch['metro'] == $metroItem->id) selected @endif
                        value="{{ $metroItem->id }}">{{ $metroItem->value }}</option>
                    @endforeach

                </select>
            </div>

        @endif

        <div class="form-item select position-relative">
            <select name="national_id" id="national">
                <option value="">Национальность</option>
                @foreach($data['national'] as $nationalItem)
                    <option
                        @if(isset($dataSearch['national_id']) and $dataSearch['national_id'] and $dataSearch['national_id'] == $nationalItem->id) selected @endif
                    value="{{ $nationalItem->id }}">{{ $nationalItem->value }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-item" >
            <div class="slider-text">Цена</div>
            <div class="filter-item-slide" id="price"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['cena-ot'] ?? 1500 }}" readonly id="price-from" name="cena-ot">
                <input type="text" data-value="{{ $dataSearch['cena-do'] ?? 50000 }}" readonly class="right-input" id="price-to" name="cena-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Возраст</div>
            <div class="filter-item-slide" id="age" data-slider></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['vozrast-ot'] ?? 18 }}" readonly id="age-from" name="vozrast-ot">
                <input type="text" data-value="{{ $dataSearch['vozrast-do'] ?? 80 }}" readonly class="right-input" id="age-to" name="vozrast-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Вес</div>
            <div class="filter-item-slide" id="ves"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['ves-ot'] ?? 40 }}" readonly id="ves-from" name="ves-ot">
                <input type="text" data-value="{{ $dataSearch['ves-do'] ?? 100 }}" readonly class="right-input" id="ves-to" name="ves-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Грудь</div>
            <div class="filter-item-slide" id="grud"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['grud-ot'] ?? 0 }}" readonly id="grud-from" name="grud-ot">
                <input type="text" data-value="{{ $dataSearch['grud-do'] ?? 8 }}" readonly class="right-input" id="grud-to" name="grud-do">
            </div>
        </div>
        <button class="orange-btn">Поиск</button>
    </form>
</div>
