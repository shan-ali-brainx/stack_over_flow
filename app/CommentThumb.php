<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentThumb extends Model
{
    //
    protected $fillable=['user_id','comment_id','up_down'];
    
}
