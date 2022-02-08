<?php

use App\Http\Controllers\CrawlerController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UrlShortController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/list-more-access', [UrlShortController::class, 'listMoreAccess']);

Route::get('{pathShort}', [RedirectController::class, 'goToOriginal']);


