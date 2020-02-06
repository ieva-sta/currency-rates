@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 bg-white shadow">
                <table class="table table-hover">
                    <tbody>
                    @foreach($currencies as $currency)
                        <tr>
                            <td><a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-block">{{ $currency->symbol }}</a></td>
                            <td><a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-block">{{ $currency->code }}</a></td>
                            <td><a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-block">{{ $currency->title }}</a></td>
                            <td>
                                <a href="{{ route('currency.show', $currency->code) }}"
                                   class="d-block">{{ $currency->rates->last()->price }}</a>
                            </td>
                            <td>
                                <a href="{{ route('currency.show', $currency->code) }}" class="d-flex">
                                    <graph :currency="{{ $currency }}" :graph-id="graph-{{ $currency->code }}"
                                           :show-labels="false" :days="7"></graph>

                                    <i class="ml-1 fas fa-caret-{{ $currency->getTrend()['trend'] ? 'up' : 'down' }}"></i>
                                    {{ $currency->getTrend()['percentage'] }} %
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
