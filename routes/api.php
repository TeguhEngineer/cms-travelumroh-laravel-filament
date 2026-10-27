<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\TestimoniController;
use App\Http\Controllers\Api\PertanyaanController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\TrustBarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes return JSON responses compatible with Strapi v5 format
*/

// Settings
Route::get("/pengaturan", [SettingController::class, "index"]);

// Pakets (Umroh/Haji packages)
Route::get("/pakets", [PaketController::class, "index"]);
Route::get("/pakets/{slug}", [PaketController::class, "show"]);

// Artikels (Articles/Blog)
Route::get("/artikels", [ArtikelController::class, "index"]);
Route::get("/artikels/{slug}", [ArtikelController::class, "show"]);

// Gallery
Route::get("/galleries", [GalleryController::class, "index"]);

// Testimonials
Route::get("/testimonis", [TestimoniController::class, "index"]);

// FAQ (Pertanyaans)
Route::get("/pertanyaans", [PertanyaanController::class, "index"]);

// YouTube Videos
Route::get("/video-youtubes", [VideoController::class, "index"]);

// Trust Bar (teks di bawah cover)
Route::get("/trust-bars", [TrustBarController::class, "index"]);
