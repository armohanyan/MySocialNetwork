@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="main-body">
          <div class="row gutters-sm">
              @include('profile.aside')
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{ $user-> getNameOrUsername() }}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     {{ $user->email }}
                    </div>
                  </div>
                  <hr>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      @if (!$user->location)
                         The user has not registered his location
                      @endif
                        {{ $user-> location }}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      @if (Auth::user()->id == $user->id)
                         <a class="btn btn-info "  href="{{ route('profile.edit') }}">Edit</a>
                      @endif
                         <a class="btn btn-info "  href="{{ route('user.friends', $user->username) }}">Friends</a>
                         <a class="btn btn-info "  href="{{ route('get.albums', $user->username) }}">Albums</a>
                    </div>
                  </div>
                </div>
                  @if ( Auth::user()->isFriendWith($user) || Auth::user()->id == $user->id )
                    @include('user.status')  
                  @endif
              </div>
            </div>           
          </div>
        </div>     
    </div>
    @endsection

   