<?php

namespace App\Http\Controllers\Web;

use App\Contracts\GeoLocationServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request, Link $link, GeoLocationServiceInterface $geoLocation): RedirectResponse
    {
        if (!$link->isEnabled()) {
            abort(404);
        }

        $link->increment('clicks');

        $location = $geoLocation->locate();

        $link->visits()->create([
            'ip_address' => $request->getClientIp(),
            'user_agent' => $request->userAgent(),
            'referer'    => $request->headers->get('referer'),
            'country'    => $location['country'] ?? null,
            'city'       => $location['city'] ?? null,
        ]);

        return redirect()->away($link->original_url);
    }
}
