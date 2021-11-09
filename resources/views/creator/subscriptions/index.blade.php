@extends('layouts.app')

@section('content')
    <div class="container my-3">
        <h1 class="text-center">{{__("Subscriptions - on the test mode")}}</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Subscriptions') }}</div>

                    <div class="card-body">
                        @foreach ($subscriptions as $subscription)
                            <div class="col-md-12 mt-5">
                                <div class="card">
                                    <div class="card-header text-uppercase">{{$subscription->name}}</div>
                                    <div class="card-body">
                                        <h3>{{_("Plan name")}}: {{$subscription->plan}}</h3>
                                        <h3>{{_("Creator")}}: {{$subscription->user_name}}</h3>
                                        @if(isset($subscription->ends_at) && $subscription->ends_at < now())
                                            <h4 class="bg-danger text-white d-inline p-1">DEACTIVATED</h4>
                                        @elseif(isset($subscription->ends_at) && $subscription->ends_at > now())
                                        <h3>{{_("Ends at")}}: {{$subscription->ends_at}}</h3>
                                        @else
                                            <h4 class="bg-success text-white d-inline p-1">ACTIVE</h4>
                                            @if(isset($subscription->trial_ends_at) && $subscription->trial_ends_at > now())
                                                <h3>{{_("Trial ends at")}}: {{$subscription->trial_ends_at}}</h3>
                                            @endif
                                        @endif
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
