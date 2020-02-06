@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 bg-white shadow">
                <table class="table table-hover">
                    <tbody>
                    @foreach($currencies as $key => $currency)
                        <tr>
                            <td>
                                <a href="{{ route('currency.show', $currency->code) }}" class="d-flex">
                                    <div
                                        class="currency-logo d-flex align-items-center justify-content-center font-weight-bold">
                                        {{ $currency->symbol }}
                                    </div>
                                    <div class="d-flex flex-column justify-content-center ml-3">
                                        <h5 class="m-0 font-weight-bold">
                                            {{ $currency->code }}
                                        </h5>
                                        <p class="m-0">
                                            {{ $currency->title }}
                                        </p>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-flex align-items-center">
                                    <h5 class="m-0">{{ $currency->rates->last()->price }}</h5>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-flex align-items-center justify-content-center">
                                    <div>
                                        <graph :currency="{{ $currency }}" :graph-id="{{ $key }}"
                                               :show-labels="false" :days="7"></graph>
                                    </div>
                                    <div class="d-flex">
                                        <i class="mr-1 fas fa-caret-{{ $currency->getTrend()['trend'] ? 'up' : 'down' }}"></i>
                                        <h6>{{ $currency->getTrend()['percentage'] }} %</h6>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center my-3">
                    {{ $currencies->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
