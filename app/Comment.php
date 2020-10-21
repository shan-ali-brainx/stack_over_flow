<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['discription','user_id','post_id'];
    public function users(){

    }
    public function posts(){
        return $this->belongsTo(Post::class);
    }
    public function comments_thumbs(){
        return $this->hasMany(Thumb::class);
    }
    public function thumbsUp(){
        return $this->hasMany(Thumb::class)->where('up_down',1);
    }
    public function thumbsDown(){
        return $this->hasMany(Thumb::class)->where('up_down',0);
    }
    
}
