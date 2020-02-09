@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidenav')
            <div class="col bg-light shadow p-0">
                <div class="currency-header">
                    <div class="py-5">
                        <h1 class="text-center font-weight-bold">{{ $currency->title }}</h1>
                        <h2 class="text-center font-weight-bold">{{ $currency->rates->last()->price }}</h2>
                    </div>
                    <graph :graph-id="{{ $currency->id }}" :currency="{{ $currency }}" :show-labels="true"
                           :days="30"></graph>
                </div>
                <currency-data-table fetch-url="{{ route('currency.rates', $currency->code) }}"></currency-data-table>
            </div>
        </div>
    </div>
@endsection
