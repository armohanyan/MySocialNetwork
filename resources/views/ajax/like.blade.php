
 @if ( Auth::user()->id !== $status->user->id )
    <button data-like="likeButton" class="btn btn-primary" id="likeButton"> <i class="fa fa-gittip"></i> Like</button>
 @endif
<span> {{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count() ) }} </span>
