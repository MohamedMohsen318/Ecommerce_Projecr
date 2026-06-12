@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="card">
        <h1>Register</h1>
        <form class="form" method="POST" action="{{ route('register') }}">
            @csrf
            <label class="field">
                <span>Name</span>
                <input class="input" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </label>
            <label class="field">
                <span>Email</span>
                <input class="input" type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label class="field">
                <span>Phone</span>
                <input class="input" type="text" name="phone" value="{{ old('phone') }}">
            </label>
            <label class="field">
                <span>Address</span>
                <textarea name="address" rows="3">{{ old('address') }}</textarea>
            </label>
            <label class="field">
                <span>Password</span>
                <input class="input" type="password" name="password" required>
            </label>
            <label class="field">
                <span>Confirm password</span>
                <input class="input" type="password" name="password_confirmation" required>
            </label>
            <button class="button" type="submit">Create account</button>
        </form>
    </section>
@endsection
