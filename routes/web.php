<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ContactsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {
    // PhotoControllerのリソースルート
    Route::resource('photos', PhotoController::class);

    // PhotoControllerその他のアクション
    Route::get('/search', [PhotoController::class, 'search'])->name('photos.search');
    Route::post('/photos/{photo}/repost', [PhotoController::class, 'repost'])->name('photos.repost');
    Route::get('/calendar', [PhotoController::class, 'getPhotosForCalendar'])->name('photos.calendar');

    // RatingControllerのルート
    Route::get('/photos/{photo}/rate', [RatingController::class, 'saveRating'])->name('photo.rate');
    Route::post('/photos/{photo}/rate', [RatingController::class, 'saveRating'])->name('photo.rate');
    Route::delete('/photos/{photo}/rate/{rating}', [RatingController::class, 'destroyRating'])->name('photos.rate.destroy');    
});

//問い合わせ
Route::get('/contact', [ContactsController::class, 'index'])->name('contact.index');
Route::post('/contact/confirm', [ContactsController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/thanks', [ContactsController::class, 'send'])->name('contact.send');