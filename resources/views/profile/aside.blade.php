<div class="col-md-4 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
          @if( $user->avatar )
             <img src="{{ $user->getAvatarPath($user->id) . $user->avatar }}" alt="Admin" class="rounded-circle" width="150">
          @else
              <img src="{{ $user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="150">
          @endif
          <div class="mt-3">
            <h4> {{ $user->getNameorUsername()}}</h4>
            <p class="text-secondary mb-1">{{ $user->username }}</p>

            @if(Auth::user()->hasFriendRequestPending($user) )
            <p> I am Waiting {{ $user->getNameOrusername() }}</p>

            @elseif( Auth::user()->hasFriendRequestReceived($user) )
                <a href="" class="btn btn-primary">Accept friend request</a>
            @elseif(Auth::user()->isFriendWith($user))
                <p>  {{ $user->getNameOrUsername() }} already is friend .</p>
            @elseif ( Auth::user()->id !== $user->id)
                <a href="{{ route('add.friends', $user->username) }}" class="btn btn-primary">Add Friend</a>
            @endif
            @if(Auth::user()->id !== $user->id)
                <button class="btn btn-outline-primary">Message</button>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
          <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
          <span class="text-secondary">https://bootdey.com</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
          <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
          <span class="text-secondary">bootdey</span>
        </li>
      </ul>
    </div>
  </div>