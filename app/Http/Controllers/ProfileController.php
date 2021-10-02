<?php

namespace App\Http\Controllers;
use App\Models\User ;
use App\Models\Status ;
use Auth ;
use Image ; 
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function getProfile($username){
      $user =  User::where('username', $username)->first() ;
      $statuses = Status::notReply()->where('user_id' , $user->id) 
       ->orderBy('created_at', 'DESC')
       ->paginate(10);
      
      if( ! $user){
          abort(404) ; 
      }
   
         return view('profile.index')->with([
            'user'=>$user,
            'statuses' => $statuses
         ]);
   }

   public function getEdit(){
      $user = Auth::user(); 
      return view('profile.edit')->with( compact('user'));
   }

   public function setEdit(Request $request ){

      if( $request->hasFile('avatar')) {  

         $user = Auth::user(); 

         $user->clearAvatar($user->id); 

         $avatar = $request->file('avatar'); 
         $filename = time() . '.' . $avatar->getClientOriginalExtension(); 

         Image::make($avatar)->resize(300, 300)
               ->save( public_path( $user->getAvatarPath($user->id) . $filename ));

         $user->avatar = $filename ; 
         $user->save(); 
         
      }

      $this->validate($request, [
         'first_name' => 'alpha|max:25' , 
         'last_name' => 'alpha|max:25' , 
         'location' => 'max:50' , 
      ]) ;

      Auth::user()->update([
         'first_name' => $request->input('first_name'),
         'last_name' => $request->input('last_name'), 
         'location' => $request->input('location')
      ]) ; 

      return redirect()
         ->route('profile.edit')
         ->with('info', 'Profile updated successfully');
   }
}
