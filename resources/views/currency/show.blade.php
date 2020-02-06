@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 bg-white shadow">
                <h1 class="text-center">{{ $currency->title }}</h1>

                <graph :id="graph-{{ $currency->id }}" :currency="{{ $currency }}" :show-labels="true"
                       :days="30"></graph>
            </div>
        </div>
    </div>
@endsection
