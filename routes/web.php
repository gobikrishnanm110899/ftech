<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');
Route::post('/vehicles/{vehicle}/enquiry', [FrontendController::class, 'enquiry'])->middleware('throttle:5,1')->name('vehicles.enquiry');

Route::get('/category/{category:slug}', [FrontendController::class, 'category'])->name('category.show');
Route::get('/category/{category:slug}/{subcategory:slug}', [FrontendController::class, 'subcategory'])->scopeBindings()->name('subcategory.show');
Route::get('/category/{category:slug}/{subcategory:slug}/{vehicle:slug}', [FrontendController::class, 'vehicle'])->scopeBindings()->name('vehicle.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('subcategories', SubcategoryController::class)->except(['show']);
        Route::resource('vehicles', VehicleController::class)->except(['show']);
        Route::get('vehicles/{vehicle}/gallery', [GalleryController::class, 'edit'])->name('vehicles.gallery');
        Route::post('vehicles/{vehicle}/gallery', [GalleryController::class, 'store'])->name('vehicles.gallery.store');
        Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
        Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
