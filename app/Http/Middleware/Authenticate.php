<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/admin/dang-nhap')->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        }
        return $next($request);
    }
}
