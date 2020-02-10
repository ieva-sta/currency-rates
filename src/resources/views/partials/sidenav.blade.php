<nav class="main-menu bg-primary shadow">
    <ul>
        <li class="nav-item">
            <a href="{{ route('currency.index') }}" class="nav-link">
                <i class="fas fa-2x fa-home mr-2"></i>
                Home
            </a>
        </li>
        @foreach($currencies as $item)
            <li class="nav-item">
                <a class="nav-link p-0 d-flex justify-content-between align-items-center"
                   href="{{ route('currency.show', $item->code) }}">
                    <div class="p-2 symbol text-center">
                        {{ $item->symbol }}
                    </div>
                    <div class="currency-title text-right pr-3">
                        {{ $item->title }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
