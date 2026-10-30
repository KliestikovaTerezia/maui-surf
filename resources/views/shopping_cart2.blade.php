@extends('layouts.app')

@section('title', 'Shopping cart')

<!-- napis maui surf -->
@php
    $showOverlay = true;
@endphp


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shopping_cart2.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/shopping_cart1.js') }}"></script>
@endpush

@section('content')
    <div class="cart-heading">
        <p>Fill out your information</p>
        <div class="steps">
            <p><i class="bi bi-1-circle"></i>.<span class="step">step</span></p>
            <p class="this-step"><i class="bi bi-2-circle"></i>.<span class="step">step</span></p>
            <p><i class="bi bi-3-circle"></i>.<span class="step">step</span></p>
        </div>
    </div>
    <div class="bag">
        <div class="fill-info">
            <form id="checkout-form" class="checkout-form" method="POST" action="{{ route('order.process') }}">
                @csrf
                <div class="customer-shipping">
                    <p>Customer Information</p>

                    <input 
                        type="text" 
                        name="firstName" 
                        placeholder="First Name" 
                        autocomplete="given-name" 
                        required 
                        value="{{ old('firstName', $firstName) }}" 
                    >

                    <input 
                        type="text" 
                        name="lastName" 
                        placeholder="Last Name" 
                        autocomplete="family-name" 
                        required 
                        value="{{ old('lastName', $lastName) }}" 
                    >

                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email Address" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email', $email) }}" 
                    >

                    <input 
                        type="tel" 
                        name="phone" 
                        placeholder="Phone Number" 
                        autocomplete="tel" 
                        required 
                        value="{{ old('phone', $phone) }}" 
                    >

                    <div class="shipping-method">
                        <p>Shipping Method</p>
                        <div class="shipping-radios">
                            <label>
                                <input type="radio" name="shipping" value="standard" data-cost="3.99" required checked> 
                                Standard Shipping <span>3,99$</span>
                            </label>
                            <label>
                                <input type="radio" name="shipping" value="express" data-cost="6.99"> 
                                Express Shipping <span>6,99$</span>
                            </label>
                        </div>
                    </div>

                    <div class="shipping-method payment-method">
                        <p>Payment Method</p>
                        <div class="shipping-radios">
                            <label><input type="radio" name="payment" value="card" required checked> Card</label>
                            <label><input type="radio" name="payment" value="applepay"> Apple Pay</label>
                            <label><input type="radio" name="payment" value="paypal"> PayPal</label>
                            <label><input type="radio" name="payment" value="googlepay"> Google Pay</label>
                            <label><input type="radio" name="payment" value="cod"> Cash On Delivery</label>
                        </div>
                    </div>
                </div>

                <div class="address">
                    <p>Billing Information</p>
                    <input type="text" name="town" placeholder="Town" autocomplete="address-level2" required>
                    <input type="text" name="street" placeholder="Street" autocomplete="street-address" required>
                    <input type="text" name="houseNumber" placeholder="House Number" required>
                    <input type="text" name="region" placeholder="Region" autocomplete="address-level1" required>
                    <input type="text" name="postalCode" placeholder="Postal Code" autocomplete="postal-code" required>

                    <!--dynamicky vyber, 'Skús si pamätať, čo tam užívateľ naposledy zadal, a keď to nevieš, použi to, čo máme uložené v databáze.'-->
                    <select name="country" required>
                        <option value="" disabled selected>Country</option>
                        <option value="SK" {{ old('country', $country) == 'SK' ? 'selected' : '' }}>Slovakia</option>
                        <option value="CZ" {{ old('country', $country) == 'CZ' ? 'selected' : '' }}>Czech Republic</option>
                        <option value="AU" {{ old('country', $country) == 'AU' ? 'selected' : '' }}>Austria</option>
                        <option value="DE" {{ old('country', $country) == 'DE' ? 'selected' : '' }}>Germany</option>
                        <option value="UK" {{ old('country', $country) == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="AS" {{ old('country', $country) == 'AS' ? 'selected' : '' }}>Australia</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="buttons">
            <div class="final-info">
                <p class="shipping-cost"><span class="bold2">Shipping: </span>3.99$</p>
                <div id="cart-data" data-total="{{ $total }}"></div>
                <p class="total"><span class="bold2">Total: </span>{{ number_format($total, 2) }}$</p>
            </div>
            <a href="{{ route('shopping_cart1') }}"><button class="shop-button">Go Back</button></a>
            <button type="submit" form="checkout-form" id="continue-button" class="checkout-button" disabled>Continue</button>
        </div>
    </div>
@endsection