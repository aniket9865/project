@extends('front.layout.app')

@section('content')
    <div class="thank-you-container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <h1>Thank You for Your Order!</h1>
            <p>Your order has been successfully placed. We appreciate your business!</p>
            <p>Your Order Id is: {{$id}}</p>
            <a href="{{ route('front.home') }}" class="btn btn-primary">Return to Home</a>
            <p>
                View your order details <a href="{{ route('front.order') }}">here</a>.
            </p>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        // Custom JavaScript (if needed)
    </script>
@endsection
