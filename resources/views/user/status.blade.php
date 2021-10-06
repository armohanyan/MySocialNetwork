
      <div class="card gedf-card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="posts-tab"   a-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">
                        Make a publication
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                    <div class="form-group">
                        <form class=" mt-1" action="{{ route('add.status') }}" method="POST" >
                            @csrf
                            <textarea  name="body" class="form-control p-0 {{ $errors->has('body') ? '      ' : '' }}  " 
                                  placeholder="What's new {{ Auth::user()->getfirstNameOrUsername() }} ?"  
                                  id="floatingTextarea2" style="height: 150px; width:550px">
                            </textarea>

                            @if ($errors->has('body'))
                                <small  class="invalid-feedback">
                                    {{ $errors->first('body') }}
                                </small>
                            @endif

                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary  m-1 mr-4">Share</button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>  
      @if( $statuses->count() )
        @foreach ( $statuses as $status )
                <div class="card gedf-card mt-2">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                  <a href="{{ route('user.profile',  $status->user->username) }}">
                                    <div class="mr-2">
                                        @if( $user->avatar )
                                            <img src="{{ $user->getAvatarPath($user->id) . $user->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                        @else
                                            <img src="{{ $user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                        @endif   
                                    </div>
                                   </a>
                                <a href="{{ route('user.profile',  $status->user->username) }}">
                                    <div class="ml-2">
                                        <div class="h5 m-0">{{ $status->user->getNameOrUSername() }}</div>
                                    </div>
                                  </a>
                            </div> 
                            @if (Auth::user()->id == $user->id)
                                <div>
                                    <a href="{{ route('destroy.status', $status->id) }}">Delete</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> {{ $status->created_at->diffForHumans() }}</div>   
                        <h4 class="card-title">{{ $status->body }} </h4>                    
                    </div>
                    <hr>
                    <div class="container mt-3 ">
                        <div class="d-flex  row">
                            <div class="" style="width: 720px">
                                 <div class="d-flex flex-column comment-section">    
                                    <div class="bg-white p-2">
                                     @foreach ( $status->comments as $comment )
                                        <div class="media">
                                            <a class="pull-left" href="{{ route('user.profile', $comment->user->username ) }}">
                                                @if( $comment->user->avatar )
                                                <img src="{{  $comment->user->getAvatarPath( $comment->user->id) .$comment->user->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                                @else
                                                    <img src="{{  $comment->user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                                @endif                                           </a>
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
                                    <div class="bg-light p-2 col-md-25">
                                      <div class="d-flex flex-row align-items-start">
                                            @if(  Auth::user()->avatar )
                                                <img src="{{   Auth::user()->getAvatarPath(  Auth::user()->id) . Auth::user()->avatar }}" alt="Admin" class="rounded-circle" width="50">
                                            @else
                                                <img src="{{   Auth::user()->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                                            @endif      
                                        <form class="mt-1 ml-3" action="{{ route('post.comment', $status->id ) }}" method="POST" >
                                            @csrf
                                            <textarea  name="comment-{{ $status->id }}" class="form-control p-0{{ $errors->has('comment-'.$status->id ) ? 'is-invalid' : '' }} "style="height: 90px; width:550px"> </textarea>
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
                        <button data-id="{{ route('get.like', $status->id) }}" class="btn btn-primary likeButton" > <i class="fa fa-gittip"></i> Like</button>
                    @endif
                        <span> ( {{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count() ) }} )</span>
                </div>
                </div>
            @endforeach
        @else
        <h1>There is no status yet </h1>
      @endif

 <script type="text/javascript">  

    $(document).ready(function() {
        $(".likeButton").click(function(e){
            e.preventDefault(); 
            $route = $(this).data("id")   
            $self = $(this)
            $.ajax({
                url: $route, 
                type:'GET',
                dataType: 'html', 
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    const r = JSON.parse(response)       
                    if(r.status !== false){
                    $self.parent('#like-button-result').html(r.html)
                    }
                }    
            });
            
        });        
    });
  </script>