@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 bg-white shadow">
                <index-data-table fetch-url="{{ route('currency.table') }}"></index-data-table>
            </div>
        </div>
    </div>
@endsection
