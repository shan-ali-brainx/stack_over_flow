<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CommentDelete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $comment=request()->post;
        $user = User::find(auth()->user()->id);
        
        if($user->role == "admin" || $comment->user_id == $user->id){
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
