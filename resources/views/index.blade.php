@extends('layouts.layout')

@section('content')
 @if( $statuses->count())
    <div class="container">
        @foreach ( $statuses as $status )
            <div class="card gedf-card mt-2 m-auto width-"  style="width:80%">
              <div class="card-header mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('user.profile',  $status->user->username) }}">
                            <div class="mr-2">
                                @if( $status->user->avatar )
                                <img src="{{  $status->user->getAvatarPath( $status->user->id) . $status->user->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                @else
                                    <img src="{{  $status->user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                @endif                      
                          </div>
                        </a>
                        <a href="{{ route('user.profile',  $status->user->username) }}">
                            <div class="ml-2">
                                <div class="h5 m-0">{{ $status->user->getNameOrUSername() }}</div>
                            </div>
                        </a>
                    </div> 
                    @if (Auth::user()->id == $status->user->id)
                        <div>
                            <a href="{{ route('destroy.status', $status->id) }}">Delete</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2">
                    <i class="fa fa-clock-o"></i> {{ $status->created_at->diffForHumans() }}
                </div>   
                 <h4 class="card-title">{{ $status->body }} </h4>                    
            </div>
              <hr>
            <div class="container mt-3 ">
                <div class="d-flex  row">
                    <div class="" style="width: 100%">
                      <div class="d-flex flex-column comment-section">    
                        <div class="bg-white p-2">
                           @foreach ( $status->comments as $comment )
                            <div class="media">
                                <a class="pull-left" href="{{ route('user.profile', $comment->user->username ) }}">
                                    @if( $comment->user->avatar )
                                        <img src="{{  $comment->user->getAvatarPath( $comment->user->id) .$comment->user->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                    @else
                                        <img src="{{  $comment->user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                    @endif                               
                                </a>
                                <div class="media-body"> 
                                    <h5 class="media-heading">{{ $comment->user->getNameOrUsername() }}</h5>
                                        <li style="font-size:10px "><i class="fa fa-calendar"></i>{{ $comment->created_at->diffForHumans() }}</li>
                                    <div class="body">
                                        <p>{{ $comment->body }} </p>
                                    </div>     
                                    <ul class="list-unstyled list-inline media-detail pull-right">
                                </div>
                            </div>
                         <hr> 
                        @endforeach   
                        </div>
                            <div class="bg-light p-2 col-md-25" >
                                <div class="d-flex flex-row align-items-start">
                                    @if(  Auth::user()->avatar )
                                        <img src="{{   Auth::user()->getAvatarPath(  Auth::user()->id) . Auth::user()->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                    @else
                                        <img src="{{   Auth::user()->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                    @endif 
                                    <form class="mt-1 ml-3" style="width: 100%"  action="{{ route('post.comment', $status->id ) }}" method="POST" >
                                        @csrf
                                            <textarea rows="4" cols="50" name="comment-{{ $status->id }}" class="form-control p-0 {{ $errors->has('comment-'.$status->id ) ? 'is-invalid' : '' }} ">
                                        </textarea>
                                            @if ($errors->has('comment-'.$status->id ))
                                                <small  class="invalid-feedback">
                                                    {{ $errors->first('comment-'.$status->id ) }}
                                                </small>
                                            @endif
                                        <div class="mt-2 text-right">
                                            <button class="btn btn-primary btn-sm shadow-none" type="submit">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer" id="like-button-result">   
                @if ( Auth::user()->id !== $status->user->id )
                    <button data-id="{{ route('get.like', $status->id) }}"  class="btn btn-primary likeButton" > <i class="fa fa-gittip"></i> Like</button>
                @endif
                    <span> ( {{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count() ) }} )</span>
            </div>
        </div>
        @endforeach
</div>
@else
    <h1>There is no status yet </h1>
@endif

@endsection

@section('js.content')
<script src="/js/ajaxRequest.js"></script>
@endsection