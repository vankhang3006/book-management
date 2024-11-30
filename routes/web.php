<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Book\BookController;
use App\Http\Controllers\Admin\BookCopy\BookCopyController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\Admin\RentalRecord\RentalRecordController;

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

// Route trang chủ
Route::get('/', function () {
    return view('welcome');
});

// Routes cho Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Route đăng nhập Admin
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Routes yêu cầu admin đã đăng nhập
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        });

         // Routes quản lý Category
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index'); // Danh sách Category
            Route::get('/create', [CategoryController::class, 'create'])->name('create'); // Trang thêm mới Category
            Route::post('/', [CategoryController::class, 'store'])->name('store'); // Thêm mới Category
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit'); // Trang sửa Category
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update'); // Cập nhật Category
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy'); // Xóa Category
        });
    
        Route::prefix('books')->name('books.')->group(function () {
            Route::get('/', [BookController::class, 'index'])->name('index'); // Danh sách sách
            Route::get('/create', [BookController::class, 'create'])->name('create'); // Trang thêm mới sách
            Route::post('/', [BookController::class, 'store'])->name('store'); // Lưu sách mới
            Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit'); // Trang chỉnh sửa sách
            Route::put('/{book}', [BookController::class, 'update'])->name('update'); // Cập nhật sách
            Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy'); // Xóa sách
        });

        // Thêm routes quản lý người dùng
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('book_copies')->name('book_copies.')->group(function () {
            Route::get('/', [BookCopyController::class, 'index'])->name('index');
            Route::get('/create', [BookCopyController::class, 'create'])->name('create');
            Route::post('/', [BookCopyController::class, 'store'])->name('store');
            Route::get('/{bookCopy}/edit', [BookCopyController::class, 'edit'])->name('edit');
            Route::put('/{bookCopy}', [BookCopyController::class, 'update'])->name('update');
            Route::delete('/{bookCopy}', [BookCopyController::class, 'destroy'])->name('destroy');
        });
        
        Route::prefix('rental-records')->name('rental_records.')->group(function () {
            // Hiển thị danh sách rental records
            Route::get('/', [RentalRecordController::class, 'index'])->name('index');
            // Trang tạo mới rental record
            Route::get('create', [RentalRecordController::class, 'create'])->name('create');
            // Lưu rental record mới
            Route::post('store', [RentalRecordController::class, 'store'])->name('store');
            // Trang sửa rental record
            Route::get('{rentalRecord}/edit', [RentalRecordController::class, 'edit'])->name('edit');
            // Cập nhật rental record
            Route::put('{rentalRecord}', [RentalRecordController::class, 'update'])->name('update');
            // Xóa rental record
            Route::delete('{rentalRecord}', [RentalRecordController::class, 'destroy'])->name('destroy');
        });
});

// Routes cho User
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Đăng nhập Google
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Đăng nhập Facebook
Route::prefix('auth/facebook')->group(function () {
    Route::get('/', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook.redirect');
    Route::get('/callback', [FacebookAuthController::class, 'handleFacebookCallback'])->name('facebook.callback');
});
