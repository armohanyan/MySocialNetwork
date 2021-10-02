

@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="main-body">
          <div class="row gutters-sm mr-0">
              @include('profile.aside')
            <div class="col-md-8 ">
              @if ( Auth::user()->id == $user->id )
                <div class="title">
                   <h2> {{ $user->getNameOrUsername() }}'s Images</h2>
                </div>
                <form class="mt-3 form-control" action="{{ route('post.image', $album->id) }}" enctype='multipart/form-data'  method="POST" novalidate>
                  @csrf
                  <div class="form-group">
                    <label for="album">Create Image</label>
                    <input type="file" name="image-{{ $album->id }}" class="form-control {{ $errors->has("image-$album->id") ? 'is-invalid' : '' }} " 
                    id="image-{{ $album->id }}">
                    @if( $errors->has('image-{{ $album->id }}'))
                      <small id="image-{{ $album->id }}" class="invalid-feedback">
                          {{ $errors->first("image-$album->id") }}
                      </small>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary">Create Image</button>
                </form>
              @endif
         
            <div class="photo-gallery" style="margin-top:100px">
              <div class="container">
                  <div class="intro">
                      <h4 class="text-center">{{ $album->body }} images</h4>
                  </div>
                  @if(! $album->images->count() )
                    <div class="row photos">
                      <div class="col-sm-6 col-md-4 col-lg-3 item">
                        No Image Yet!!
                      </div>  
                  </div>
                  @else
                    <div class="row photos mt-3">
                      @foreach ( $album->images as $image )
                        <div class="col-sm-10 col-md-10 col-lg-4 item">
                          <a href="{{ $image->getImagePath($album->user->id, $album->id). '/' . $image->body }}" data-lightbox="photos">
                            <img class="img-fluid" src="{{ $image->getImagePath($album->user->id, $album->id). '/' . $image->body }}">
                          </a>
                          @if(Auth::user()->id == $album->user->id)
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="btn-group">
                                <form action="{{ route('delete.image', ['albumId' => $album->id, 'imageId' => $image->id  ] )}}" method="post" style="display: inline-block" >
                                    @csrf
                                    @method('DELETE')
                                  <button  type="submit" class="btn btn-danger ">Delete</button>
                                  <small class="text-muted">{{ $image->created_at->diffForHumans() }} </small>

                                </form>
                              </div>
                            </div>
                          </div>
                          @endif
                        </div>  
                        @endforeach   
                    </div>
                    @endif
              </div>
            </div>
          </div>     
        </div>          
      </div>     
    </div>

    @endsection