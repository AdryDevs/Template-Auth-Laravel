<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class isSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = auth()->user()->id;

        $user = User::find($userId);
        $hasSuperAdminRole = $user->roles->contains(3);

        if (!$hasSuperAdminRole) {
            return response()->json([
                'success' => true,
                'message' => 'You are not authorized to access this resource'
            ],);
        }

        return $next($request);
    }
}
