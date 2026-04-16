<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403, 'User is not authenticated.');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'User does not have the required role. Has: ' . $userRole . ', Required: ' . implode(', ', $roles));
        }
        
        return $next($request);
    }
}