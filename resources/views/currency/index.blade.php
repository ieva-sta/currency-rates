@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 bg-white shadow">
                <data-table
                    fetch-url="{{ route('currency.table') }}"
                    :columns="['symbol', 'code', 'title', 'rate', 'trend']"
                ></data-table>
            </div>
        </div>
    </div>
@endsection
