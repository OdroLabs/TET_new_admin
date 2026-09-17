<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Cache::remember('api_settings_map', 3600, function () {
            return Setting::all()->mapWithKeys(function ($item) {
                $rawData = $item->getRawOriginal('value');
                $decoded = json_decode($rawData, true);

                if ($decoded !== null) {
                    return [$item->key => $decoded];
                }

                return [$item->key => trim($rawData, '"\'')];
            })->all();
        });

        return response()->json($settings);
    }
}