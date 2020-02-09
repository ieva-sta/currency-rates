@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidenav')
            <div class="col bg-light shadow p-0">
                <div class="currency-header">
                    <h1 class="text-center py-5 mb-4">{{ $currency->title }}</h1>

                    <graph :graph-id="{{ $currency->id }}" :currency="{{ $currency }}" :show-labels="true"
                           :days="30"></graph>
                </div>
                <currency-data-table fetch-url="{{ route('currency.rates', $currency->code) }}"></currency-data-table>
            </div>
        </div>
    </div>
@endsection
