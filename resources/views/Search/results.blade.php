@extends('layouts.layout')

@section('content')
   <div class="row">
    <div class="col-lg-10">
     <h3>Result of Search : {{ Request::input('query') }}</h3>
     @if(!$users->count())
          <p>User is not found</p>
     @else
     <div class="row">
          <div class="col-lg-6">
               @foreach ($users as $user )
                 @include('user.userblock') 
               @endforeach
          </div>
     @endif
     </div>
   </div>
@endsection