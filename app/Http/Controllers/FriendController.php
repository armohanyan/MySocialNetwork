<?php

namespace App\Http\Controllers;
use App\Models\User ;
use Auth ;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function getIndex($username) { 
      $user =  User::where('username', $username)->first() ;
      $friends = Auth::user()->friendRequests();
        if(!$user){
            abort(404) ; 
        }
  
        return view('friend.index',[
          'user' => $user, 
          'friends' => $friends 
        ]);
     
     }

     public function getAdd($username){
      $user =  User::where('username', $username)->first() ;

      
      if( Auth::user()->id === $user->id ){
        return  redirect()
                ->route('home');
     }

      if( ! $user ){
        return  redirect()
                 ->route('home')
                 ->with('info', 'User is not found');
      }

      if( Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user()) ){
        return  redirect()
                ->route('user.profile', $user->username)
                ->with('info', 'User send a friend request already');
     }

     if( Auth::user()->isFriendWith($user) ){
        return  redirect()
                ->route('user.profile', $user->username)
                ->with('info', 'User is friend already');
     }

     Auth::user()->addFriend($user); 
        return  redirect()
                ->route('user.profile', $user->username)
                ->with('info', 'A request has been sent to the user');
    
  }

  public function getAccept($username){
    $user =  User::where('username', $username)->first() ;

    if( Auth::user()->id === $user->id ){
        return  redirect()
              ->route('home');
   }

    if( ! $user ){
         return  redirect()
               ->route('home')
               ->with('info', 'User is not found');
    }

    if( Auth::user()->isFriendWith($user) ){
         return  redirect()
              ->route('user.profile', $user->username)
              ->with('info', 'User is friend already');
    }

    if( ! Auth::user()->hasFriendRequestReceived($user)){
        return  redirect()
              ->route('home');
    }

     Auth::user()->acceptFriendsRequest($user);
         return  redirect()
              ->route('user.profile', $user->username)
              ->with('info', 'A request accepted');
  }     

  public function deleteFriend($username){
    $user =  User::where('username', $username)->first() ;

    if(  Auth::user()->hasFriendRequestReceived($user) ){
        Auth::user()->deleteFriend($user); 

        return redirect()->back()->with('info', 'User has been deleted');; 
    }
  
    if( ! Auth::user()->isFriendWith($user) ){  
        return redirect()->back(); 
    }
 
       Auth::user()->deleteFriend($user); 

       return redirect()->back()->with('info', 'User has been deleted');; 
  } 

} 