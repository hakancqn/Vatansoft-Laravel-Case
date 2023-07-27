<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');
        $expectedKey = '$xv1623tty';

        if ($apiKey !== $expectedKey) {
            Log::create(['ip' => $request->ip()]);

            $cacheKey = 'error_count_' . $request->ip();
            $errorCount = Cache::get($cacheKey, 0);
            $errorCount++;

            if ($errorCount > 30) {
                return response()->json(['error' => 'Hatalı istek limiti aşıldı.'], 429);
            }

            Cache::put($cacheKey, $errorCount, now()->addMinutes(1));

            return response()->json(['error' => 'Geçersiz API key.'], 401);
        }

        return $next($request);
    }
}