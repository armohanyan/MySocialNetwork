@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="main-body">
          <div class="row gutters-sm mr-0">
              @include('profile.aside')
            <div class="col-md-8 ">
              @if ( Auth::user()->id == $user->id )
                <div class="title">
                <h2>My Albums</h2>
                </div>
                <form class="mt-3 form-control " action="{{ route('post.album') }} "  method="POST" >
                  @csrf
                  <div class="form-group">
                    <label for="album">Create Album</label>
                    <input type="text" name="album" class=" {{ $errors->has('album') ? 'is-invalid' : '' }} " id="album" aria-describedby="album" placeholder="Enter Album name" required >
                    @if( $errors->has('album'))
                      <small id="album" class="invalid-feedback">
                          {{ $errors->first('album') }}
                      </small>
                    @endif
                  </div>
                  <div>
                  <button type="submit" class="btn btn-primary">Create Album</button>
                </div>
                </form>
              @endif
              @if ( Auth::user()->isFriendWith($user) ||  Auth::user()->id == $user->id )
               <div class="row " style="margin-top:80px ">
                @if ( ! $albums->count())
                  
                @else 
                 @foreach ($albums as $album )             
                    <div class="col-md-4" >
                      <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="{{ $album->getAvatarUrl() }}">
                        <div class="card-body">
                          <h6>{{ $album->body }}</h6>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                              <a href="{{ route('get.image', [ 'albumId'=> $album->id ,'username' => $user->username ] ) }} " class="btn btn-sm btn-outline-secondary">View</a>
                              @if (Auth::user()->id == $album->user->id)
                                <form action="{{ route('delete.album', $album->id)}}" method="post" style="display: inline-block" >
                                    @csrf
                                    @method('DELETE')
                                  <button  type="submit" class="btn btn-danger ">Delete</button>
                                </form>
                              @endif
                            </div>
                          </div>
                          <small class="text-muted">{{ $album->created_at->diffForHumans() }} </small>
                        </div>
                      </div>
                    </div>                
                 @endforeach
                @endif
            </div>
            @endif
          </div>
        </div>          
      </div>     
</div>
@endsection