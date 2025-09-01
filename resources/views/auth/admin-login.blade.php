@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">Admin Login</h2>
        <div class="card my-5">
          <form method="POST" action="{{ route('login') }}" class="card-body cardbody-color p-lg-5">
            @csrf
            <div class="mb-3">
              <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp"
                value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark px-5 mb-5 w-100">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
