<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;

// --- Giao diện người dùng (CLIENT) ---
Route::get('/', [ClientHomeController::class, 'index'])->name('home');

// Sản phẩm
Route::get('/products/{slug}', [ClientProductController::class, 'show'])->name('product.show');
Route::get('/danh-muc/{slug}', [ClientProductController::class, 'category'])->name('product.category');
Route::get('/thuong-hieu/{slug}', [ClientProductController::class, 'brand'])->name('product.brand');
Route::get('/tim-kiem', [ClientProductController::class, 'search'])->name('product.search');

// Giỏ hàng
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/cap-nhat', [CartController::class, 'update'])->name('cart.update');
Route::post('/gio-hang/xoa', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/thanh-toan', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/dat-hang', [CartController::class, 'placeOrder'])->name('cart.placeOrder');

// --- Các Route Demo / Test ---
Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{param1}/{param2}', [DemoController::class, 'index6']);

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);


// --- PHÂN HỆ ADMIN (QUẢN TRỊ) ---
// Gom tất cả vào prefix 'admin' và đặt tên chung là 'admin.' để đồng bộ với View
Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication (Không cần đăng nhập)
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');

    // Các Route yêu cầu đăng nhập (Middleware 'auth')
    Route::middleware('auth')->group(function () {

        // Đăng xuất
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Đổi mật khẩu
        Route::get('/changepassword', [AuthController::class, 'changePassword'])->name('changepassword');
        Route::post('/changepassword', [AuthController::class, 'postChangePassword'])->name('changepassword.post');

        // Trang chủ Admin (Dashboard)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Giữ lại tên 'admin.home' cho sidebar tương thích (redirect về dashboard)
        Route::get('/home', function () {
            return redirect()->route('admin.dashboard');
        })->name('home');

        // Các Route Resource (Đầy đủ chức năng CRUD)
        Route::middleware('roles:1')->group(function () {
            // Hiển thị danh sách dữ liệu đã xóa mềm Soft Delete (Thùng rác)
            Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
            // Khôi phục
            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            // Xóa vĩnh viễn
            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

            Route::resource('categories', CategoryController::class);
            Route::resource('brands', BrandController::class);
            Route::resource('users', UserController::class);
            Route::resource('products', ProductController::class);
            Route::delete('product-images/{id}', [ProductController::class, 'destroyImage'])->name('products.destroyImage');
            Route::resource('posts', PostController::class);
        });

        Route::resource('products', ProductController::class)->only(['index'])->middleware('roles:2');

    });
});