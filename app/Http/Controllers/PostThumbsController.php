<?php

namespace App\Http\Controllers;

use App\PostThumb;
use Illuminate\Http\Request;

class PostThumbsController extends Controller
{

    //
    public function thumb(Request $request)
    {
        

        // $postThumbs = PostThumb::where('post_id', $request->post_id)->where('user_id', auth()->user()->id)->first();
        // $postThumbs = Post::find($request->post_id)->thumbs()->where('user_id', auth()->user()->id)->first();
        $new_data = [
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ];

        if ($request->thumb === 'up') {
            $new_data['up_down'] = 'up';
        } else {
            $new_data['up_down'] = 'down';
        }

        PostThumb::updateOrCreate([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ],
            $new_data
        );
        

        $count = PostThumb::where('post_id', $request->post_id)->get();
        $returnValue = count($count->where('up_down', 'up'))-count($count->where('up_down', 'down'));

        return $returnValue;
    }

}
