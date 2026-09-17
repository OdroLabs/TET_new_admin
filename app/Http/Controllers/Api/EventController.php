<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Cache::remember('api_events_list', 3600, function () {
            return Event::where('is_published', true)
                ->orderBy('order', 'asc')
                ->get()
                ->map(function (Event $ev) {
                    return [
                        'id' => $ev->id,
                        'title' => $ev->getTranslations('title'),
                        'cat' => $ev->getTranslations('cat'),
                        'date' => $ev->date,
                        'location' => $ev->getTranslations('location'),
                        'excerpt' => $ev->getTranslations('excerpt'),
                        'fullStory' => $ev->getTranslations('full_story'),
                        'img' => $ev->cover_image,
                        'gallery' => $ev->gallery_images ?? [],
                    ];
                })
                ->values()
                ->all();
        });

        return response()->json($events);
    }
}