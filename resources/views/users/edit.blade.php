@extends('layouts.app')

@section('content')
<h2>Edit User Profile</h2>
<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div class="form-group">
        <label>Profile Picture</label>
        @if($user->profile_pic)
            <div style="margin-bottom: 8px;">
                <img src="{{ asset('storage/' . $user->profile_pic) }}" class="avatar">
            </div>
        @endif
        <input type="file" name="profile_pic" accept="image/*">
    </div>
    <button type="submit" class="btn">Update User</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection