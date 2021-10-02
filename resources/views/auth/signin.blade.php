@extends('layouts.layout')


@section('content')
<div class="row">
    <div class="col-lg-4 m-auto ">
        <div class="m-3 mt-5 text-center"><h2>Sing in</h2></div>
        <form method="POST" action="{{ route('auth.signin') }}" novalidate>
            @csrf
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email"
                value="{{ Request::old('email') ? Request::old('email') : '' }}" 
                class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                id="email" aria-describedby="emailHelp" placeholder="Enter email">

              @if($errors->has('email'))
                 <small  class="invalid-feedback">
                    {{ $errors->first('email') }}
                 </small>
              @endif
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" 
                class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                name="password" id="password" placeholder="Password">

              @if($errors->has('password'))
                <small class="invalid-feedback">
                  {{ $errors->first('password') }}
                </small>
              @endif
            </div>
            <div class="col-auto">
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                  <label class="form-check-label p-0" for="autoSizingCheck">
                        Remember me 
                  </label>
                </div>
              </div>
             <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>

@endsection