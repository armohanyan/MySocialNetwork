

  <div class="card p-2 mt-2 mr-2" style="font-size:12px " >
      <div class="d-flex align-items-center">
          <div class="image">
                @if( $user->avatar )
                    <img src="{{ $user->getAvatarPath($user->id) . $user->avatar }}" alt="Admin" class="rounded-circle" width="50">
                @else
                    <img src="{{ $user->getAvatarUrl() }}" alt="Admin" class="rounded-circle" width="50">
                @endif
             </div>
          <div class="ml-3 ">
              <h6 class="mb-0 mt-0" style="width:max-content" > {{ $user->getNameorUsername()}}</h6>
              <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats" style="width: 150px">
                  <div class="d-flex flex-column"> 
                      <span class="articles">Photos</span>
                      <span class="number1">0</span>
                  </div>
                  <div class="d-flex flex-column"> 
                      <span class="followers">Friends</span> 
                      <span class="number2">0</span> 
                  </div>
                  <div class="d-flex flex-column">
                       <span class="rating">Posts</span> 
                       <span class="number3">0.0</span> 
                  </div>
              </div>
              <div class="button mt-2 d-flex flex-row align-items-center"> 
                  <a href="{{ route('user.profile', $user->username) }}" class="btn btn-sm btn-outline-primary w-75">View</a> 
                  @if ( Auth::user()->id !== $user->id)

                    @if(Auth::user()->hasFriendRequestPending($user) )
                        <p> I am Waiting {{ $user->getNameOrusername() }}</p>
                        @elseif( Auth::user()->hasFriendRequestReceived($user) )
                            <a href="{{ route('accept.friends', $user->username ) }}" class="btn btn-sm btn-primary w-75">Accept</a>
                            <a href="{{ route('delete.friend', $user->username ) }}" class="btn btn-sm btn-primary w-75">Delete</a>

                        @elseif(Auth::user()->isFriendWith($user))
                            <a href="{{ route('delete.friend', $user->username ) }}" class="btn btn-sm btn-primary w-75">Delete</a>
                        @elseif ( Auth::user()->id !== $user->id)
                            <a href="{{ route('add.friends', $user->username) }}" class="btn btn-primary">Add Friend</a>
                        @endif                   
                    @endif
              </div>
          </div>
      </div>
</div>