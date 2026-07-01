<?php

namespace App\Filament\Plugins\LocaleSwitcher\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetPanelLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale') ?? app()->getLocale();

        App::setLocale($locale);

        return $next($request);
    }
}
