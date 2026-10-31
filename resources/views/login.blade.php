@extends('layouts.app')

@section('title', 'Log In')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<div class="store-name text-center overlay-text">
    <a href="{{ route('homepage') }}" aria-label="Homepage">
        Maui Surf
    </a>
</div>


<main class="prihlasovacky">
    <div class="background-image"></div>
    <div class="row justify-content-center mx-0">
        <!-- Log In-->
        <div class="prihlasovacky_box col-md-5 p-5 rounded shadow-sm">
            <h2 class="text-center">LOG IN</h2>
            @if ($errors->login->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->login->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form  method="POST" action="{{ route('login') }}">  <!--prihlasovacie udaje-->
                @csrf
                <div class="mb-2">
                    <input type="email" name='email' class="form-control" placeholder="e-mail..." required>
                </div>
                <div class="mb-2">
                    <input type="password" name='password' class="form-control" placeholder="password..." required>
                </div>
                <button type="submit" class="button_prihlasenie">Log In</button>
                <a href="#" class="forgotten_password">Forgotten password</a>
            </form>
        </div>

        <!-- Register-->
        <div class="prihlasovacky_box col-md-5 p-5 rounded shadow-sm ms-md-4 mt-4 mt-md-0">
            <h2 class="text-center">REGISTER</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-2 ">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-2">
                    <input type="email" name="email" class="form-control" placeholder="e-mail" required>
                </div>
                <div class="mb-2">
                    <input type="tel" name="phone_number" class="form-control" placeholder="Phone number" required>
                </div>
                <div class="mb-2">
                    <input type="text" name="country" class="form-control" placeholder="Country" required>
                </div>
                <div class="mb-2">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-2">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="button_prihlasenie">Register</button>
            </form>
        </div>
    </div>
</main>
@endsection