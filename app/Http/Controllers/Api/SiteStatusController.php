<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Read by the website's proxy on every page request:
 * is Coming Soon on, should search engines be blocked, and is this visitor
 * holding the admin preview key (so they see the real site).
 */
class SiteStatusController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $given = (string) $request->query('key', '');
        $key = Setting::text('site_preview_key');

        return response()->json([
            'coming_soon' => Setting::text('site_coming_soon') === '1',
            'noindex' => Setting::text('site_noindex') === '1',
            'preview' => $given !== '' && $key !== '' && hash_equals($key, $given),
        ])->header('Cache-Control', 'no-store');
    }
}
