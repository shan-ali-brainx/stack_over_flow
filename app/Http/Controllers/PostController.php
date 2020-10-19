<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        return view('post_question');
    }
    public function create(Request $request){
        $input = $request->only(['question']);
        $validator = Validator::make($request->all(),[
            'question' => 'required',
        ]);
    //    $input['user_id'] = auth()->user()->id;
       auth()->user()->posts()->create($input);
       return redirect()->route('dashboard');        
    }

    public function show(Post $post){
        return view('post_question',compact('post'));
    }

    public function update(Request $request, Post $post) {
        $post = Post::find($post->id);
        //$post->update(['question' => $request->input('question')]);
        $post->update($request->all());
        return redirect()->route('dashboard');
    }

    public function delete(Post $post){
        $post->delete();
        return redirect()->route('dashboard');
    }
 }
