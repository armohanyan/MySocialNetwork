<?php

namespace App\Http\Controllers;
use App\Models\User ;
use App\Models\Album ;
use Auth ;
use Image ; 
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function getAlbum($username){
 
        $user = User::where('username', $username)->first(); 

        if( ! $user){
            abort(404);
        }

        $albums =  Album::GetOnlyAlbum()->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get(); 

        return view('album.index')->with([
            'user' => $user, 
            'albums' => $albums
        ]); 
    }

    public  function postAlbum(Request $request){

        $this->validate($request, [
            'album' => 'required|max:25' ,
        ]); 
      
        Auth::user()->albums()->create([
            'body' => $request->input('album'),
        ]);

        return redirect()
                ->back()
                ->with('info', 'Album was created successfully ');
    }

    public function getImage($albumId, $username){

        $user = User::where('username', $username)->first(); 

        $album = Album::find($albumId);

        if( ! $album ){
            return redirect()->back() ; 
        } 

        return view('album.images')->with([
            'user' => $user,
            'album' => $album
        ]); ;
    }

    public function postImage(Request $request,  $albumId){

        $album = Album::find($albumId);

        if( ! $album ) {
            return redirect()->back() ; 
        }

        $this->validate($request, [
            "image-$albumId" => 'required' , 
        ]) ;

        $user = Auth::user() ; 

        if( $request->hasFile("image-$albumId") ){

            $requestImage = $request->file("image-$albumId") ; 
            $filename = time() . '.' . $requestImage->getClientOriginalExtension(); 

            $image = new Album ; 
            $image->body = $filename;
            $image->user()->associate( Auth::user() ); 
            $album->images()->save($image) ;
            
            Image::make($requestImage)->resize(400, 400)
                    ->save( public_path( $album
                    ->getImagePath(Auth::user()->id,  $album->id ) . $filename ));

            return redirect()->back()->with('info', 'Image uploaded successfully');

        }
    }
    public function getLike($imageId){

        $image = Album::find($imageId);

        if(  Auth::user()->hasLikedImage($image) ) {
             return redirect()->back(); 
        } 

        if( ! $image ) redirect()-back(); 

        $image->likes()->create([
            'user_id' => Auth::user()->id , 
        ]);

        return redirect()->back();
    }

    public function deleteAlbum($albumId){

        $album = Album::find($albumId); 

        $image = Album::where('parent_id', $albumId) ;

        if( ! $album ) redirect()->back() ;

        $album->removeAlbum(Auth::user()->id,$albumId); 
        
        $album->delete(); 
        $image->delete(); 

        return redirect()->back()->with('info', 'Album deleted successfully') ; 

    }

    public function deleteImage($albumId, $imageId){

        $image = Album::find($imageId); 
    
        if( ! $image) redirect()->back() ;

        $image->deleteImage($albumId, Auth::user()->id, $image->body) ; 

        $image->delete();

        return redirect()->back();  
    }

}
