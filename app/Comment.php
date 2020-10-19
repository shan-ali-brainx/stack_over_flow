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
        return $this->hasMany(CommentThumb::class);
    }
    
}
