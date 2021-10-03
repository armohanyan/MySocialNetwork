<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'username',
        'first_name',
        'last_name',
        'location',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName(){

        if( $this->first_name && $this->last_name ){
            return  $this->first_name.' '.$this->last_name ;
        }

        if( $this->first_name ){
            return $this->first_name ;
        }

        return null ; 
    }   

    public function statuses(){
        return $this->hasMany('App\Models\Status') ;
    }

    public function likes(){
        return $this->hasMany('App\Models\Like') ;
    }

    public function albums(){
        return $this->hasMany('App\Models\Album'); 
    }
    
    public function getNameOrUsername(){
        return $this->getName() ? : $this->username ; 
     }

     public function getfirstNameOrUsername(){
        return $this->first_name ? : $this->username ; 
     }

     public function getAvatarUrl(){
         return "https://www.gravatar.com/avatar/md5({{$this->email}})?d=mp&s" ; 
     }

     public function friendsOfMine(){
         return $this->belongstoMany('App\Models\User', 'friends', 'user_id', 'friend_id') ; 
     }

     public function friendOf(){
         return $this->belongstoMany('App\Models\User', 'friends', 'friend_id', 'user_id') ; 
     }

     public function friends(){
         return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge( $this->friendOF()->wherePivot('accepted', true)->get() ) ; 
     }

     public function friendRequests(){
         return $this->friendsOfMine()->wherePivot('accepted', false)->get(); 
     }

     public function friendRequestPending(){
         return $this->friendOf()->wherePivot('accepted', false)->get(); 
     }

     public function hasFriendRequestPending(User $user){
         return (bool) $this->friendRequestPending()->where('id', $user->id)->count() ; 
     }

     public function hasFriendRequestReceived(User $user){
        return (bool) $this->friendRequests()->where('id', $user->id)->count() ; 
    }

    public function addFriend(User $user){
        return $this->friendOf()->attach($user->id) ; 
    }   

    public function deleteFriend(User $user){
         $this->friendOf()->detach($user->id) ;
         $this->friendsOfMine()->detach($user->id) ; 
    }

    public function acceptFriendsRequest(User $user){ 
        return  $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
        ]);
    }

    public function isFriendWith(User $user){
        return (bool) $this->friends()->where('id', $user->id)->count() ; 
    }
    
    public function hasLikedStatus(Status $status){
        return (bool) $status->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedImage(Album $image){
        return (bool) $image->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function clearAvatar($user_id){
        $path = "Upload/avatar/id{$user_id}" ;

        if( file_exists( public_path("/$path")) ){
            foreach( glob(public_path("/$path/*")) as $avatar )  
            unlink($avatar) ;
        }
    }

    public function getAvatarPath($user_id){
        $path = "Upload/avatar/id{$user_id}" ;
        if( ! file_exists($path)) mkdir($path, 0777, true) ;

        return "/$path/"; 
    }
}
 