<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User ; 
use DB;
class SearchController extends Controller
{
    public function getResults(Request $request){
        
        $query = $request->input('query') ; 

        if(!$query){

            return redirect()->route('home');
            
        }

          $user = User::where(DB::raw("CONCAT(first_name, '', last_name)"),
                'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->get() ;   

                return view('search.results')->with('users', $user      ); 

    }
}
