<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Closure;

class Admin extends Model
{
    use HasFactory;
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
