@extends('layouts.layout')

@section('content')
    <h1>Error 404</h1>
    <p>
        Page not found. Go to  <a class="btn btn-link"  href="{{ route('home') }}" >Status </a>
    </p>
@endsection