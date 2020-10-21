<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

  

    public function create(Request $request){
        $input = $request->only(['discription','post_id']);
        $validator = $request->validate([
            'discription' => 'required',
            'post_id'=> 'exists:posts,id'
        ]);

        $input['user_id']=auth()->user()->id;
        Comment::create($input);
        return redirect()->route('dashboard');
    }
    public function delete(Comment $comment){
        $comment->delete();
        return redirect()->route('dashboard');
        
    }
    public function update(Request $request){
        
        $comment = Comment::find($request->comment_id);
        $comment->update(['discription'=>$request->comment_discription]);
        return $comment->refresh();

    }
}
