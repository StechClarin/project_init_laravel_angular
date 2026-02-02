<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMood
{
    public function handle($request, Closure $next)
    {
        if (in_array($request->route()->getName(), ['login', 'login.post', 'mood.select', 'mood.store', 'logout'])) {
            return $next($request);
        }

        if (Auth::check()) {
            $user = Auth::user();

            $lastMood = $user->moods()->latest()->first();
            if ($lastMood && $lastMood->created_at->isToday()) {
                return $next($request);
            }

            if ($request->route()->getName() !== 'mood.select') {
                return redirect()->route('mood.select')
                    ->with('warning', 'Veuillez sélectionner votre humeur pour aujourd\'hui.');
            }
        }

        return $next($request);
    }
}
