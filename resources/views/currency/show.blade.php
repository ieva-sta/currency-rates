@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <ul class="nav flex-column bg-white">
                    @foreach($currencies as $item)
                        <li class="nav-item currency-list list-group-item-action {{ $item->code === $currency->code ? 'active' : '' }}">
                            <a class="nav-link d-flex align-items-center"
                               href="{{ route('currency.show', $item->code) }}">
                                <div
                                    class="currency-logo d-flex align-items-center justify-content-center font-weight-bold">
                                    {{ $item->symbol }}
                                </div>
                                <div>
                                    <h6 class="mb-0 ml-2">{{ $item->title }}</h6>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-9 bg-white shadow p-3">
                <h1 class="text-center my-3">{{ $currency->title }}</h1>

                <graph :graph-id="{{ $currency->id }}" :currency="{{ $currency }}" :show-labels="true"
                       :days="30"></graph>
            </div>
        </div>
    </div>
@endsection
