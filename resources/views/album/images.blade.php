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
                    <input type="file" name="image-{{ $album->id }}" class="form-control {{ $errors->has("image-$album->id") ? 'is-invalid' : '' }} " id="image-{{ $album->id }}">

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
                            <div class="col-sm-6 col-md-6 col-lg-5 item">
                              <strong> {{ $user->getNameOrUsername() }} has not album yet.  </strong>
                            </div>  
                          </div>
                        @else
                        <div class="row photos mt-3"> 
                            @foreach ( $album->images->sortByDesc('created_at') as $image )
                              <div class="col-sm-10 col-md-10 col-lg-4 item">
                                <a href="{{ $image->getImagePath($image->user->id, $album->id). '/' . $image->body }}" data-lightbox="photos">
                                  <img class="img-fluid" src="{{ $image->getImagePath($album->user->id, $album->id). '/' . $image->body }}"></a>
                                    <div class="card-body">
                                      <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                          @if(Auth::user()->id == $image->user->id)
                                            <form action="{{ route('delete.image', ['albumId' => $album->id, 'imageId' => $image->id  ] )}}" method="post" style="display: inline-block" >
                                              @csrf
                                              @method('DELETE')
                                              <button  type="submit" class="btn btn-danger ">Delete</button>
                                            </form>
                                          @endif
                                          @if (  Auth::user()->id !== $image->user->id)
                                            <a class="btn btn-primary" href=" {{ route('get.image.like', ['imageId' => $image->id ]) }}"> Like ( {{ $image->likes->count() }} ) </a>
                                          @else
                                            <span class="btn btn-primary"> {{ Str::plural('like', $album->likes->count()) }} ( {{ $image->likes->count() }} )</span>
                                          @endif
                                       </div>
                                    </div>
                                    <hr>
                                      <small class="text-muted"> Created at {{ $image->created_at->diffForHumans() }} </small>
                                 </div>
                               </div>
                             @endforeach 
                          </div>    
                        </div>
                      @endif
                 </div>
            </div>
        </div>     
      </div>          
  </div>     
</div>

@endsection
    