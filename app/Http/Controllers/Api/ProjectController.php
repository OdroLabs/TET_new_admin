<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Cache::remember('api_projects_list', 3600, function () {
            return Project::where('is_published', true)
                ->orderBy('order', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->map(fn (Project $p) => [
                    'id' => $p->id,
                    'category' => $p->getTranslations('category'),
                    'title1' => $p->getTranslations('title1'),
                    'title2' => $p->getTranslations('title2'),
                    'summary' => $p->getTranslations('summary'),
                    'long_desc' => $p->getTranslations('long_desc'),
                    'status' => $p->getTranslations('status'),
                    'images' => array_values($p->images ?? []),
                ])
                ->values()
                ->all();
        });

        return response()->json($projects);
    }
}
