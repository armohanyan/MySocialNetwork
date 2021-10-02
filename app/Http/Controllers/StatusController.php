<?php

namespace App\Http\Controllers;
use Auth ;
use App\Models\Status; 
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function postStatus(Request $request){
        
       $this->validate($request, [
            'body' => 'required|max:1000' , 
       ]);

       Auth::user()->statuses()->create([
          'body' => $request->input('body')
       ]); 

           
       return redirect()
            ->route('user.profile', Auth::user()->username)
            ->with('info', 'Status was  posted succesfully ');
    }

    public function destroy($id){
        Status::where('id', $id)->delete(); 
             return redirect()->back(); 
    }

    public function postComment(Request $request, $statusId){
      
        $this->validate($request, [
            "comment-{$statusId}" => 'required',
        ],
        
         [
            'required'=> 'The comment must be field'
        ]); 

        $status = Status::notReply()->find($statusId); 
        
        if( ! $status ) redirect()->back();     
        
        $comment = new Status ; 
        $comment->body = $request->input("comment-{$statusId}") ;
        $comment->user()->associate(Auth::user()) ; 
        $status->comments()->save($comment); 

        return redirect()->back() ; 
    }

    public function getLike($statusId){

        $status = Status::find($statusId); 

        if( ! $status) redirect()->back(); 

        if( Auth::user()->hasLikedStatus($status) ){
            return redirect()->back();
        }

        if( Auth::user()->hasLikedStatus($status) ) redirect()->back();

        $status->likes()->create([
            'user_id' => Auth::user()->id, 
        ]);     

        return redirect()->back() ; 
    }
}
