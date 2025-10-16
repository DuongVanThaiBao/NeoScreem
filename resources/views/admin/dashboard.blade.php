@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Xin chào, {{ Auth::user()->name }}!</h1>
    <p>Chào mừng đến trang quản trị Admin.</p>
</div>
@endsection
