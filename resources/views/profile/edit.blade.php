@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="main-body">
      <div class="row gutters-sm">
              @include('profile.aside')
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-body ">
              <div class="row">
                <div class="col-lg-10 "> 
                  <div class="text-center"><h2>Edit</h2></div>
                    <form method="POST"  action="{{ route('profile.edit') }} "  enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                          <label for="avatar">Avatar</label>
                          <input type="file" name="avatar" class="form-control-file" id="avatar">
                        </div>
                        <div class="form-group">
                          <label for="first_name">First Name</label>
                          <input type="text" name="first_name"
                            value="{{ Request::old('first_name') ? : Auth::user()->first_name }}" 
                            class="form-control  {{ $errors->has('first_name') ? 'is-invalid' : '' }}" 
                            id="first_name" >
                          
                          @if($errors->has('first_name'))
                            <small  class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </small>
                          @endif
                        </div>
                        <div class="form-group">
                          <label for="last_name">Last Name</label>
                          <input type="text" name="last_name"
                            value="{{ Request::old('last_name') ? : Auth::user()->last_name }}" 
                            class="form-control  {{ $errors->has('last_name') ? 'is-invalid' : '' }}" 
                            id="last_name"  >
                          
                          @if($errors->has('last_name'))
                            <small  class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </small>
                          @endif
                        </div>
                          <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location"
                              value="{{ Request::old('location') ? : Auth::user()->location }}"
                              class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" 
                              id="location" >

                            @if($errors->has('location'))
                              <small class="invalid-feedback">
                                {{ $errors->first('location') }}
                            </small>
                            @endif
                          </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    @endsection