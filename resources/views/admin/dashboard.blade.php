@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-muted">This is your admin dashboard.</p>
        </div>
    </div>
</div>
@endsection
