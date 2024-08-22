<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
/**
* Handle an incoming request.
*
* @param \Illuminate\Http\Request $request
* @param \Closure $next
* @param string $role
* @return mixed
*/
public function handle(Request $request, Closure $next, ...$roles)
{
if (Auth::check() && in_array(Auth::user()->id_type_user, $roles)) {
return $next($request);
}

// Jika tipe_user tidak cocok, arahkan pengguna ke halaman lain atau tampilkan pesan error
return redirect('/')->with('error', 'You do not have permission to access this page.');
}
}
