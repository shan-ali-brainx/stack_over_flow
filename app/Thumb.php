<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumb extends Model
{
    //
    protected $fillable=['post_id','comment_id','user_id','up_down'];
}
