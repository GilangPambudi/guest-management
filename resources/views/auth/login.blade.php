@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="w-100" style="max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-2">Welcome to QREW</h2>
            <p class="mb-3 text-muted">Quick Response Elegant Wedding is a simple platform to manage your wedding guests efficiently.</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h4 class="mb-4 text-center">{{ __('Login') }}</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                </div>

                @if (Route::has('password.request'))
                    <div class="mt-3 text-center">
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif

                @if (Route::has('register'))
                    <div class="mt-2 text-center">
                        <span class="text-muted">{{ __("Don't have an account?") }}</span>
                        <a class="text-decoration-none ms-1" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
