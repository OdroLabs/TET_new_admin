<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): JsonResponse
    {
        $sitemapData = Cache::remember('api_sitemap_urls', 3600, function () {
            $activities = Activity::where('is_published', true)
                ->select('id', 'updated_at')
                ->get()
                ->map(fn($act) => [
                    'url' => "/news",
                    'lastmod' => $act->updated_at?->toAtomString() ?? now()->toAtomString(),
                ]);

            $events = Event::where('is_published', true)
                ->select('id', 'updated_at')
                ->get()
                ->map(fn($ev) => [
                    'url' => "/gallery",
                    'lastmod' => $ev->updated_at?->toAtomString() ?? now()->toAtomString(),
                ]);

            return [
                'activities' => $activities,
                'events' => $events,
            ];
        });

        return response()->json($sitemapData);
    }
}