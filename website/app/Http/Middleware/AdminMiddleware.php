<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login dan role = admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/dashboard'); // lempar ke user dashboard
        }

        return $next($request);
    }
}

?>