<?php

namespace App\Http\Middleware;

use App\Models\Paste;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPastePassword
{
    /**
     * Check if the paste is password-protected and redirect to
     * the password gate if it hasn't been verified yet.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if ($slug) {
            $paste = Paste::bySlug($slug)->first();

            if ($paste && $paste->isPasswordProtected()) {
                $verifiedPastes = session()->get('verified_pastes', []);

                if (! isset($verifiedPastes[$paste->slug])) {
                    return redirect()->route('pastes.password', $paste->slug);
                }
            }
        }

        return $next($request);
    }
}
