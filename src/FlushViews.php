<?php

namespace Skurian\Dolly;

use Cache;

class FlushViews
{
    public function handle($request, $next)
    {
        if (app()->environment() === 'local') {
            Cache::tags('views')->flush();
        }

        return $next($request);
    }
}