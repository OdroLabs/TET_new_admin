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

                // If value is null/empty
                if ($rawData === null || $rawData === '') {
                    return [$item->key => ''];
                }

                // Attempt to decode JSON (for trilingual { en: ..., si: ..., ta: ... })
                if (is_string($rawData) && (str_starts_with($rawData, '{') || str_starts_with($rawData, '['))) {
                    $decoded = json_decode($rawData, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return [$item->key => $decoded];
                    }
                }

                // Otherwise, treat as a clean string (stripping extra quotes or escapes)
                return [$item->key => trim($rawData, "\"'")];
            })->toArray(); // 👈 CRUCIAL: Must be ->toArray() so cache stores a pure array!
        });

        return response()->json($settings);
    }
}