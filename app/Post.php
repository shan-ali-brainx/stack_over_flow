<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    
    protected $fillable=['question','user_id'];
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function thumbs(){
        return $this->hasMany(Thumb::class);
    }

    public function thumbsCount(){
        return $this->hasMany(Thumb::class);
    }

    public function thumbsUp(){
        return $this->hasMany(Thumb::class)->where('up_down',1);

    }
    public function thumbsDown(){
        return $this->hasMany(Thumb::class)->where('up_down',0);

    }
}
