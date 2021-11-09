@extends("layouts.app")
@section('content')
    <header>
        <div class="container">
            <h1 class="text-center">{{__("Create and sell your unique, memorable quote")}}</h1>
        </div>
    </header>
    <section>
        <div class="container mt-4">
            <h2>{{__("Donate, and sustain this app (test donations - not a live version)")}}</h2>
            <form class="form mt-4" action="{{ route("paypal.payment") }}" method="post" id="paypal_form">
                @csrf
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="lc" value="UK">
                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
                <input type="hidden" name="first_name" value="Customer's First Name">
                <input type="hidden" name="last_name" value="Customer's Last Name">
                <input type="hidden" name="payer_email" value="customer@example.com">
                <input type="hidden" name="item_number" value="123456">
                <button type="submit" name="submit" class="btn btn-primary">{{__("Submit Payment")}}</button>
            </form>
        </div>
    </section>
@endsection
