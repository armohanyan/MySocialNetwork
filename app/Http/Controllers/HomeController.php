<?php

namespace App\Http\Controllers;
use Auth ;
use App\Models\Status; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $statuses = Status::notReply()->where( function($query){
            
            return $query->where('user_id' , Auth::user()->id)
                ->orWhereIn('user_id' , Auth::user()->friends()->pluck('id') ); })
                ->orderBy('created_at', 'DESC')->paginate(10);  

             return view('index')->with(compact('statuses')) ;
    }
}
