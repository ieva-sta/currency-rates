@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidenav')
            <div class="col bg-light p-0">
                <div class="bg-white show-view">
                    <div class="py-5">
                        <h1 class="text-center font-weight-bold">{{ $currency->title }}</h1>
                        <h2 class="text-center font-weight-bold">{{ $currency->rates->last()->price }}</h2>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-7">
                                <graph :graph-id="{{ $currency->id }}" :currency="{{ $currency }}" :show-labels="true"
                                       :days="30"></graph>
                            </div>
                            <div class="col-5">
                                <currency-data-table
                                    fetch-url="{{ route('currency.rates', $currency->code) }}"></currency-data-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
