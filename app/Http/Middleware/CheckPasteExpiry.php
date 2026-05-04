<?php

namespace App\Http\Middleware;

use App\Models\Paste;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasteExpiry
{
    /**
     * Check if the paste has expired and return 410 if so.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if ($slug) {
            $paste = Paste::bySlug($slug)->first();

            if ($paste && ($paste->isExpired() || $paste->hasBurned())) {
                return response()->view('pastes.expired', ['paste' => $paste], 410);
            }
        }

        return $next($request);
    }
}
