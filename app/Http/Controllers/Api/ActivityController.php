<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        $activities = Cache::remember('api_activities_list', 3600, function () {
            return Activity::where('is_published', true)
                ->orderBy('order', 'asc')
                ->get()
                ->map(function (Activity $act) {
                    return [
                        'id' => $act->id,
                        'title' => $act->getTranslations('title'),
                        'date' => $act->date,
                        'location' => $act->getTranslations('location'),
                        'excerpt' => $act->getTranslations('excerpt'),
                        'fullStory' => $act->getTranslations('full_story'),
                        'img' => $act->image,
                    ];
                })
                ->values()
                ->all();
        });

        return response()->json($activities);
    }
}