@extends('layouts.app')

@section('title', 'Shopping cart')

<!-- napis maui surf -->
@php
    $showOverlay = true;
@endphp


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shopping_cart3.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/shopping_cart1.js') }}"></script>
@endpush

@section('content')
    <div class="cart-heading">
        <p>The last step</p>
        <div class="steps">
            <p><i class="bi bi-1-circle"></i>.<span class="step">step</span></p>
            <p><i class="bi bi-2-circle"></i>.<span class="step">step</span></p>
            <p class="this-step"><i class="bi bi-3-circle"></i>.<span class="step">step</span></p>
        </div>
    </div>
    <div class="bag">
        <div class="fill-info">
            <div class="supported">
                <p>Supported payment methods</p>
                <div class="logos">
                    <img src="images/visa.png" alt="visa is supported" class="supported-pay-img">
                    <img src="images/mastercard.png" alt="mastercard is supported" class="supported-pay-img">
                    <img src="images/applepay.png" alt="apple pay is supported" class="supported-pay-img">
                    <img src="images/paypal.png" alt="pay pal is supported" class="supported-pay-img">
                    <img src="images/googlepay.png" alt="google pay is supported" class="supported-pay-img">
                </div>
            </div>
            <form id="checkout-form" class="checkout-form" method="POST" action="{{ route('order.process') }}">
                @csrf
                <p>Card Information</p>
                <input type="text" name="cardName" placeholder="Name on Card" required>
                <input type="text" name="cardNum" placeholder="Card Number" pattern="[0-9]{13,16}" maxlength="19" required>
                <div class="date-cvc">
                    <input type="text" name="expDate" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" maxlength="5" required>
                    <input type="text" name="cvc" placeholder="CVC" pattern="[0-9]{3,4}" maxlength="4" required>
                </div>
            </form>
        </div>
        <div class="buttons">
            <div class="final-info">
                <p class="shipping-cost"><span class="bold2">Shipping: </span><span id="shipping-amount">—</span></p>
                <p class="total"><span class="bold2">Total: </span><span id="total-amount">—</span></p>
            </div>
            <a href="{{ route('shopping_cart2') }}"><button class="shop-button">Go Back</button></a>
            <button type="submit" form="checkout-form" id="purchase-button" class="checkout-button" disabled>Purchase</button>
        </div>
    </div>
@endsection