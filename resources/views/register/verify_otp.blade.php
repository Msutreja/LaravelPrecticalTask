@extends('layouts.app')
@section('content')


<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4>Verify Otp</h4>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf

           <div class="mb-3">
                <label>Enter OTP sent to your email:</label>
                <input type="text" name="otp" class="form-control">
           </div>

            <button type="submit" class="btn btn-dark w-100">Verify</button>
        </form>
    </div>
</div>

@endsection
