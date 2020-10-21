<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Thumb;
use Illuminate\Http\Request;

class ThumbController extends Controller
{
    //

    public function thumb(Request $request){
       
        Thumb::updateOrCreate(
            [
                'comment_id' => $request->comment_id,
                'post_id'=>$request->post_id,
                'user_id' => auth()->user()->id,
            ],$request->all()
        );
       
        if($request->type === 'post'){
            return (Post::where('id',$request->post_id)->withCount('thumbsUp')->first()->thumbs_up_count) - (Post::where('id',$request->post_id)->withCount('thumbsDown')->pluck('thumbs_down_count')[0]);
        }
        else
            return (Comment::where('id',$request->comment_id)->withCount('thumbsUp')->pluck('thumbs_up_count')[0]) - (Comment::where('id',$request->comment_id)->withCount('thumbsDown')->pluck('thumbs_down_count')[0]);
    }
}
