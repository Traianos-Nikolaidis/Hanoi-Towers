<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotStudent
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'student') {
            return redirect()->route('home')->withErrors(['You do not have permission to create a quiz.']);
        }

        return $next($request);
    }
}
