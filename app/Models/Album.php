<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File ;
use Storage;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 
     ];

    public function user(){
        return $this->belongsTo('App\Models\User') ;
    }
  
    public function likes(){
      return $this->morphMany('App\Models\Like', 'likeable'); 
     }

    public function images(){
        return $this->hasMany('App\Models\Album', 'parent_id'); 
    }

    public function getAvatarUrl(){
      $path = '/images/gellary.jpg' ;
      
      if( file_exists( public_path($path) ) ){
          return $path;    
      } 
     }

    public function getImagePath($user_id, $album_id){
        $path = "album{$album_id}/Images{$user_id}" ; 
        
        if( ! file_exists($path) ) mkdir($path, 0777, true) ; 
        
        return  "/$path/"; 

      }

    public function removeAlbum($user_id, $album_id){
      $path = "album{$album_id}" ; 

      if (\File::exists($path)) \File::deleteDirectory($path);

      return redirect()->back()->with('info', 'Album does not excist!');

    }

    public function deleteImage($album_id, $user_id , $filename){
      
      $path = "album{$album_id}/Images{$user_id}/$filename" ; 

      if( file_exists( public_path($path)) ) unlink($path);

      return redirect()->back()->with('info', 'Image does not excist!');
    }

    public function scopeGetOnlyAlbum($query){
      return $query->whereNull('parent_id') ;
    }

}
