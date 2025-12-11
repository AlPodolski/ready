<section class="filter-bar">
    <div class="container">
        <div class="filter-row">
            <button class="filter-chip" type="button" data-open-filters>
                Фильтры
            </button>

            <button class="filter-chip" type="button">
                Цена
                <span class="chip-value">до 5000</span>
            </button>

            <button class="filter-chip" type="button">
                Район
            </button>

            <button class="filter-chip" type="button">
                Метро
            </button>

            <button class="filter-chip filter-chip--icon" type="button">
                <span class="dot"></span>
                Онлайн
            </button>

            <button class="filter-chip" type="button">
                Проверенные
            </button>
        </div>
    </div>
</section>

<div class="filter-overlay" data-filter-close></div>

<aside class="filter-panel" aria-hidden="true">
    <div class="filter-panel__header">
        <h2>Фильтры</h2>
        <button class="filter-close" type="button" data-filter-close>&times;</button>
    </div>

    <form method="GET" action="/poisk">
        @csrf
        <div class="filter-section">
            <div class="filter-section__title">Цена</div>
            <div class="filter-price">
                <input type="number" name="price_from" placeholder="от" class="price-input"
                       value="{{ $dataSearch['cena-ot'] ?? '1500' }}" min="1500" max="50000">
                <span class="dash">—</span>
                <input type="number" name="price_to" placeholder="до" class="price-input"
                       value="{{ $dataSearch['cena-do'] ?? 50000 }}" min="1500" max="50000">
                <span class="currency">руб</span>
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-section__title">Возраст</div>
            <div class="filter-range">
                <input type="number"
                       name="vozrast-ot"
                       placeholder="от"
                       class="range-input"
                       value="{{ $dataSearch['vozrast-ot'] ?? 18 }}" min="18" max="80">
                <span class="dash">—</span>
                <input type="number"
                       name="vozrast-do"
                       placeholder="до"
                       class="range-input"
                       value="{{ $dataSearch['vozrast-do'] ?? 80 }}" min="18" max="80">
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-section__title">Вес</div>
            <div class="filter-range">
                <input type="number"
                       name="ves-ot"
                       placeholder="от"
                       class="range-input"
                       value="{{ $dataSearch['ves-ot'] ?? 40 }}" min="40" max="100">
                <span class="dash">—</span>
                <input type="number"
                       name="ves-do"
                       placeholder="до"
                       class="range-input"
                       value="{{ $dataSearch['ves-do'] ?? 100 }}" min="40" max="100">
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-section__title">Грудь</div>
            <div class="filter-range">
                <input type="number"
                       name="grud-ot"
                       placeholder="от"
                       class="range-input"
                       value="{{ $dataSearch['grud-ot'] ?? 0 }}" min="0" max="8">
                <span class="dash">—</span>
                <input type="number"
                       name="grud-do"
                       placeholder="до"
                       class="range-input"
                       value="{{ $dataSearch['grud-do'] ?? 8 }}" min="0" max="8">
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-section__title">Выезд / Формат</div>
            <div class="filter-tags">
                <label class="tag">
                    <input type="checkbox" name="na_vyezd" value="1">
                    <span>Выезд</span>
                </label>
                <label class="tag">
                    <input type="checkbox" name="s_video" value="1">
                    <span>С видео</span>
                </label>
                <label class="tag">
                    <input type="checkbox" name="proverennye" value="1">
                    <span>Проверенные</span>
                </label>
            </div>
        </div>

        @if($data['rayon'])
            <div class="filter-section">
                <button class="acc__btn filter-acc__btn" type="button" aria-expanded="false">
                    Район
                    <span class="acc__icon"></span>
                </button>
                <div class="acc__panel" hidden>
                    <div class="filter-checklist">
                        @foreach($data['rayon'] ?? [] as $item)
                            <label>
                                <input type="checkbox" name="rayon[]" value="{{ $item->id }}">
                                <span>{{ $item->value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($data['metro'])
            <div class="filter-section">
                <button class="acc__btn filter-acc__btn" type="button" aria-expanded="false">
                    Метро
                    <span class="acc__icon"></span>
                </button>
                <div class="acc__panel" hidden>
                    <div class="filter-checklist">
                        @foreach($data['metro'] ?? [] as $item)
                            <label>
                                <input type="checkbox" name="metro[]" value="{{ $item->id }}">
                                <span>{{ $item->value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="filter-section">
            <button class="acc__btn filter-acc__btn" type="button" aria-expanded="false">
                Национальность
                <span class="acc__icon"></span>
            </button>
            <div class="acc__panel" hidden>
                <div class="filter-checklist">
                    @foreach($data['national'] ?? [] as $item)
                        <label>
                            <input type="checkbox" name="national[]" value="{{ $item->id }}">
                            <span>{{ $item->value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Услуги --}}
        <div class="filter-section">
            <button class="acc__btn filter-acc__btn" type="button" aria-expanded="false">
                Услуги
                <span class="acc__icon"></span>
            </button>
            <div class="acc__panel" hidden>
                <div class="filter-checklist">
                    @foreach($data['service'] ?? [] as $item)
                        <label>
                            <input type="checkbox" name="service[]" value="{{ $item->id }}">
                            <span>{{ $item->value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Низ панели --}}
        <div class="filter-panel__footer">
            <button type="submit" class="filter-submit">Показать</button>
        </div>
    </form>
</aside>

<div class="side-menu d-none" id="filter">
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
                            @if(isset($dataSearch['metro']) and $dataSearch['metro'] and $dataSearch['metro'] == $metroItem->id) selected
                            @endif
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
                        @if(isset($dataSearch['national_id']) and $dataSearch['national_id'] and $dataSearch['national_id'] == $nationalItem->id) selected
                        @endif
                        value="{{ $nationalItem->id }}">{{ $nationalItem->value }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-item">
            <div class="slider-text">Цена</div>
            <div class="filter-item-slide" id="price"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['cena-ot'] ?? 1500 }}" readonly id="price-from"
                       name="cena-ot">
                <input type="text" data-value="{{ $dataSearch['cena-do'] ?? 50000 }}" readonly class="right-input"
                       id="price-to" name="cena-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Возраст</div>
            <div class="filter-item-slide" id="age" data-slider></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['vozrast-ot'] ?? 18 }}" readonly id="age-from"
                       name="vozrast-ot">
                <input type="text" data-value="{{ $dataSearch['vozrast-do'] ?? 80 }}" readonly class="right-input"
                       id="age-to" name="vozrast-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Вес</div>
            <div class="filter-item-slide" id="ves"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['ves-ot'] ?? 40 }}" readonly id="ves-from" name="ves-ot">
                <input type="text" data-value="{{ $dataSearch['ves-do'] ?? 100 }}" readonly class="right-input"
                       id="ves-to" name="ves-do">
            </div>
        </div>

        <div class="form-item">
            <div class="slider-text">Грудь</div>
            <div class="filter-item-slide" id="grud"></div>
            <div class="inputs">
                <input type="text" data-value="{{ $dataSearch['grud-ot'] ?? 0 }}" readonly id="grud-from"
                       name="grud-ot">
                <input type="text" data-value="{{ $dataSearch['grud-do'] ?? 8 }}" readonly class="right-input"
                       id="grud-to" name="grud-do">
            </div>
        </div>
        <button class="orange-btn">Поиск</button>
    </form>
</div>
