@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="main-body">
          <div class="row gutters-sm mr-0" style="flex-wrap: nowrap">
              @include('profile.aside')
            <div class="col-md-5 ">
              <div class="card mb-3">

                @if ( Auth::user()->id  == $user->id)
                    <h3 class="text-center m-3"> Your  friends   </h3>
                @else
                    <h3 class="text-center m-3">{{ $user->getNameOrUSername() }}  friends   </h3>
                @endif  

                @if ( ! $user->friends()->count() )
                    @if ( Auth::user()->id  == $user->id )
                        <h6 class="ml-2">You  have   not friends yet.</h6>
                    @else
                        <h6  class="m-auto">{{ $user->getNameOrUSername() }} has not friends.</h6>
                    @endif
                        @else 
                    <div class="container mt-3 d-flex " style="flex-wrap:wrap " >
                        @foreach ($user->friends() as $user )
                            @include('user.userblock')
                        @endforeach 
                    </div>
                @endif

              </div>
            </div>
            <div class="col-md-4   ">
                <div class="card mb-3">
                    <h4>Friends Request</h4>
                    @if (!$friends->count())
                        <p>You have not friend Request yet. </p>
                    @else 
                    @foreach ($friends as $user)
                        @include('user.userblock')
                    @endforeach
                    @endif
                </div>  
            </div>
           </div>
         </div>
     </div>
</div>
@endsection