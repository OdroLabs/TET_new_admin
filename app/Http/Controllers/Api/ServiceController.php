<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Cache::remember('api_services_list', 3600, function () {
            return Service::where('is_published', true)
                ->orderBy('order')
                ->orderBy('id')
                ->get()
                ->map(fn (Service $s) => [
                    'id' => $s->id,
                    'tag' => $s->getTranslations('tag'),
                    'title' => $s->getTranslations('title'),
                    'description' => $s->getTranslations('description'),
                    'image' => $s->image,
                ])
                ->values()
                ->all();
        });

        return response()->json($services);
    }
}
