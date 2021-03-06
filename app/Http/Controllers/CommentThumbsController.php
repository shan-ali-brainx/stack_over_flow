<?php

namespace App\Http\Controllers;

use App\CommentThumb;
use Illuminate\Http\Request;

class CommentThumbsController extends Controller
{
    public function thumb(Request $request)
    {
        
        $new_data = [
            'comment_id' => $request->comment_id,
            'user_id' => auth()->user()->id,
        ];

        if ($request->thumb === 'up') {
            $new_data['up_down'] = 'up';
        } else {
            $new_data['up_down'] = 'down';
        }

        CommentThumb::updateOrCreate([
            'comment_id' => $request->comment_id,
            'user_id' => auth()->user()->id,
        ],
            $new_data
        );
        
        $count = CommentThumb::where('comment_id', $request->comment_id)->get();
        $returnValue = count($count->where('up_down', 'up'))-count($count->where('up_down', 'down'));

        return $returnValue;
    }
}
