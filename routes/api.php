<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\EnterpriseInquiryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SitemapController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/settings', [SettingController::class, 'index']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
Route::post('/donations', [DonationController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/inquiries', [EnterpriseInquiryController::class, 'store']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/sitemap-urls', [SitemapController::class, 'index']);
