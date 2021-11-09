@extends('layouts.app')

@section('content')
    <div class="container my-3">
        @if(auth()->user()->hasRole("admin"))
        <h1 class="text-center">{{__("Donations - on the test mode")}}</h1>
        @else
        <h1 class="text-center">{{__("My donations - on the test mode")}}</h1>
        @endif
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Donations') }}</div>

                    <div class="card-body">
                        @foreach ($donations as $donation)
                            <div class="col-md-12 mt-5">
                                <div class="card">
                                    <div class="card-header text-uppercase">{{$donation->amount_value}} {{$donation->amount_currency}}</div>
                                    <div class="card-body">
                                        @if(auth()->user()->hasRole("admin"))
                                            <h2>{{$donation->name}}</h2>
                                            <h3>{{$donation->email}}</h3>
                                            <hr>
                                        @endif
                                        <h3>{{$donation->mode}}</h3>
                                        <p>{{$donation->description}}</p>
                                        <p>{{\Carbon\Carbon::parse($donation->payment_paid_at)->format("d-m-Y H:i")}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
