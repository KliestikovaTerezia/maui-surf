@extends('layouts.app')

@section('title', 'Confirmation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shopping_cart3.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/shopping_cart1.js') }}"></script>
@endpush

@section('content')
    <div class="confirmation">
        <p class="thanks">Thank you for your purchase!</p>
        <p class="email-info">You got a confirmation email<br>Your order is on its way to you!</p>
        <div class="van-line">
            <div class="line"></div>
            <img src="images/van.png" alt="image of a van carrying your package" class="van">
        </div>
        <div class="button">
            <a href="{{ route('products') }}"><button class="shop-button">Continue Shopping</button></a>
        </div>
    </div>
@endsection