@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 bg-white shadow">
                <h1 class="text-center">{{ $currency->title }}</h1>

                <canvas id="currencyGraph"></canvas>
            </div>
        </div>
    </div>
@endsection
