@extends('layouts.app')

@section('content')
<h2>Login</h2>
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
    <a href="{{ route('register') }}" style="margin-left: 10px;">Don't have an account? Register</a>
</form>
@endsection