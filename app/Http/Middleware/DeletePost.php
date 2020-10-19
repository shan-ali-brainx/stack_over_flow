<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
class DeletePost
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
        $post=request()->post;
        $user = User::find(auth()->user()->id);
        
        if($user->role == "admin" || $post->user_id == $user->id){
            return $next($request);
        }
        return redirect()->route('dashboard');
        
        // if (auth()->guest()) {
        //     return redirect('/login');
        // }



        // if (auth()->user()->role_id !== 3) {
        //     return redirect('/home');
        // }
        
        // return $next($request);
    }
}
