@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 bg-white shadow">
                <table class="table">
                    <tbody>
                    @foreach($currencies as $currency)
                        <tr>
                            <td>{{ $currency->symbol }}</td>
                            <td>{{ $currency->code }}</td>
                            <td>{{ $currency->title }}</td>
                            <td>
                                {{ $currency->rates->last()->price }}
                            </td>
                            <td>
                                <i class="ml-1 fas fa-caret-{{ $currency->getTrend()['trend'] ? 'up' : 'down' }}"></i>
                                {{ $currency->getTrend()['percentage'] }} %
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
