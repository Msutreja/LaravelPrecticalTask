@extends('layouts.app')

@section('content')
<div class="mb-3 text-end">
    <a href="{{ route('register.admin') }}" class="btn btn-outline-primary">Register Admin</a>
</div>
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4>Customer Registration</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register_customer') }}">
            @csrf

           <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                @error('first_name')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                @error('last_name')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                 @error('email')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
    </div>
</div>
@endsection
