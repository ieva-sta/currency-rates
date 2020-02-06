@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col bg-white shadow">
                <table class="table">
                    <tbody>
                    @foreach($currencies as $currency)
                        <tr>
                            <td>{{ $currency->symbol }}</td>
                            <td>{{ $currency->code }}</td>
                            <td>{{ $currency->title }}</td>
                            <td>{{ $currency->rates->last()->price }}</td>
                            <td>{{ $currency->trend }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $currencies->links() }}
            </div>
        </div>
    </div>
@endsection
