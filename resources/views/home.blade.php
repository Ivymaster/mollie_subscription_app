@extends('layouts.app')

@section('content')
    <div class="container my-3">
        <h1 class="text-center">{{ __('An unusable app - created only for payment testing') }}</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Donation') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in! In the lower form you can send a test pyment, via Mollie PG') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mollie.payment') }}" method="post" class="form">
                            @csrf
                            <div class="d-flex flex-row">
                                <input type="text" name="price" class="form-control" placeholder="20.00&euro;">
                                <button class="btn btn-primary ml-2">{{ __('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($payment_plans as $plan)
                <div class="col-md-4 mt-5">
                    <div class="card">
                        <div class="card-header text-uppercase">{{ $plan->name }}</div>
                        <div class="card-body">
                            <p>{{ $plan->description }}</p>
                            <h3 class="text-center">{{ $plan->amount }}&euro;</h3>
                            @if (auth()->user()->subscribedToPlan('main', $plan->name) == false)
                                @if (!auth()->user()->subscribed('main', $plan->name))
                                    <form action="{{ route('change_plans') }}" method="post" class="form text-center">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                                        <button class="btn btn-primary mt-3">
                                            {{ __('Choose') }}
                                        </button>
                                    </form>
                                @else
                                    @if (auth()->user()->subscription('main')->onGracePeriod())
                                        <a href="{{ route('subscriptions.resume') }}"
                                            class="btn btn-danger mt-3">{{ __('Resume') }}</a>
                                    @else
                                        <h4>{{ __('SUBSCRIBED') }}</h4>
                                        <a href="{{ route('subscriptions.cancel') }}"
                                            class="btn btn-danger mt-3">{{ __('Cancel') }}</a>
                                    @endif
                                @endif
                            @else
                                <p class="d-inline bg-success p-2">{{ __('Subscribed') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
