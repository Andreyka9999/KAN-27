@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your profile</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success mt-2 mb-3">Update profile</button>
    </form>

    <h3>Change password</h3>
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="current_password">Current password:</label>
            <input type="password" class="form-control" id="current_password" name="current_password">
            @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password">New password:</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Password confirmation:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary mt-2 mb-3">Change password</button>
    </form>

    <h3>Update profile photo</h3>
    <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profile_picture">Choose image:</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
            @error('profile_picture') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success mt-2 mb-3 ">Download image</button>
    </form>

    @if($user->profile_picture)
        <img src="{{ asset('images/' . $user->profile_picture) }}" alt="Profile photo" width="150">
    @endif
</div>
@endsection
