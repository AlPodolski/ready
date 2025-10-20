<sidebar class="sidebar col-lg-3">
    <div class="sidebar__stats">
        <div class="sidebar__stats-item">
            <svg class="sidebar__stats-icon">
                <use xlink:href='/svg/dest/stack/sprite.svg#wallet'></use>
            </svg>
            <div class="sidebar__stats-capt">Баланс:</div>
            <div class="sidebar__stats-result">
                {{ auth()->user()->cash }}р
            </div>
            <a class="sidebar__stats-walletadd" href="/cabinet/pay">
            </a>
        </div>

        @if(false)
            <div class="sidebar__stats-item">
                <svg class="sidebar__stats-icon">
                    <use xlink:href='/svg/dest/stack/sprite.svg#rate'></use>
                </svg>
                <div class="sidebar__stats-capt">Расход в час:</div>
                <div class="sidebar__stats-result">
                </div>
            </div>
            <div class="sidebar__stats-item">
                <div class="sidebar__stats-capt">Хватит на N часов (дней)</div>
                <div class="sidebar__stats-result">
                </div>
            </div>
        @endif

        <a class="btn-main sidebar__stats-button" href="/cabinet/pay">
            Пополнить баланс
        </a>
    </div>
    <div class="sidebar__menu">
        <nav class="sidebar__menu-nav">
            <ul class="sidebar__menu-list">
                <li class="sidebar__menu-item">
                    <a href="/cabinet/post/create" class="sidebar__menu-link">
                        <svg class="sidebar__menu-icon">
                            <use xlink:href='/svg/dest/stack/sprite.svg#user'></use>
                        </svg>
                        <span class="sidebar__menu-text">
                            Добавить анкету
                        </span>
                    </a>
                </li>
                <li class="sidebar__menu-item">
                    <a href="/cabinet" class="sidebar__menu-link">
                        <svg class="sidebar__menu-icon">
                            <use xlink:href='/svg/dest/stack/sprite.svg#user-card'></use>
                        </svg>
                        <span class="sidebar__menu-text">
                            Мои анкеты
                        </span>
                    </a>
                </li>
                <li class="sidebar__menu-item">
                    <a href="/cabinet/claim" class="sidebar__menu-link">
                        <svg class="sidebar__menu-icon">
                            <use xlink:href='/svg/dest/stack/sprite.svg#feedback'></use>
                        </svg>
                        <span class="sidebar__menu-text position-relative">
                            Обратная связь
                            @php
                                /* @var $notReadMessage \App\Models\ChatMessage */
                            @endphp
                            @if($notReadMessage and $notReadMessage->notRead->count())
<span class="not-read-message position-absolute">{{$notReadMessage->notRead->count()}}</span>
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar__menu-item">
                    <a href="/logout" class="sidebar__menu-link">
                        <svg class="sidebar__menu-icon">
                            <use xlink:href='/svg/dest/stack/sprite.svg#out'></use>
                        </svg>
                        <span class="sidebar__menu-text">
                            Выйти
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</sidebar>
