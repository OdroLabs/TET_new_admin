<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Cache::remember('api_products_list', 3600, function () {
            return Product::where('is_available', true)
                ->orderBy('order', 'asc')
                ->get()
                ->map(function (Product $p) {
                    return [
                        'id' => $p->id,
                        'title' => $p->getTranslations('title'),
                        'description' => $p->getTranslations('description'),
                        'price' => $p->price,
                        'currency' => $p->currency,
                        'specs' => $p->specs,
                        'badge' => $p->badge,
                        'icon' => $p->icon,
                        'image' => $p->image,
                    ];
                })
                ->values()
                ->all();
        });

        return response()->json($products);
    }
}