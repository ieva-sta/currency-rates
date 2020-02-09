<nav class="main-menu bg-white">
    <ul>
        <li class="nav-item">
            <a href="{{ route('currency.index') }}" class="nav-link">
                <i class="fas fa-2x fa-home mr-2 ml-1"></i>
                Home
            </a>
        </li>
        @foreach($currencies as $item)
            <li class="nav-item has-subnav currency-list list-group-item-action">
                <a class="nav-link d-flex align-items-center"
                   href="{{ route('currency.show', $item->code) }}">
                    <div
                        class="currency-logo d-flex align-items-center justify-content-center font-weight-bold">
                        {{ $item->symbol }}
                    </div>
                    <span class="mb-0 ml-2">{{ $item->title }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
