<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Middleware\Admin\AdminAuth;
use App\Http\Controllers\Admin\BusinessAccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Categories\SubcategoryController;
use App\Http\Controllers\Admin\Fields\FieldController;
use App\Http\Controllers\Admin\Fields\FieldOptionController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\Admin\SliderController;

// ==========================
// Authentication Routes
// ==========================

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ==========================
// Dashboard Route
// ==========================

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// ==========================
// Roles Management Routes
// ==========================

Route::middleware(['auth:admin', 'permission:view roles'])
    ->get('/admin/roles', [RoleController::class, 'index'])
    ->name('admin.roles.index');

Route::middleware(['auth:admin', 'permission:create roles'])
    ->get('/admin/roles/create', [RoleController::class, 'create'])
    ->name('admin.roles.create');

Route::middleware(['auth:admin', 'permission:create roles'])
    ->post('/admin/roles', [RoleController::class, 'store'])
    ->name('admin.roles.store');

Route::middleware(['auth:admin', 'permission:update roles'])
    ->get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])
    ->name('admin.roles.edit');

Route::middleware(['auth:admin', 'permission:update roles'])
    ->put('/admin/roles/{role}', [RoleController::class, 'update'])
    ->name('admin.roles.update');

Route::middleware(['auth:admin', 'permission:delete roles'])
    ->delete('/admin/roles/{role}', [RoleController::class, 'destroy'])
    ->name('admin.roles.destroy');

Route::middleware(['auth:admin', 'permission:assign role permissions'])
    ->get('/admin/roles/{role}/permissions', [RoleController::class, 'permissions'])
    ->name('admin.roles.permissions');

Route::middleware(['auth:admin'])
    ->put('/admin/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])
    ->name('admin.roles.permissions.update');

// ==========================
// Admins Management Routes
// ==========================

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

    Route::middleware(['permission:view admins'])
        ->get('/admins', [AdminController::class, 'index'])
        ->name('admin.admins.index');

    Route::middleware(['permission:create admins'])
        ->get('/admins/create', [AdminController::class, 'create'])
        ->name('admin.admins.create');

    Route::middleware(['permission:create admins'])
        ->post('/admins', [AdminController::class, 'store'])
        ->name('admin.admins.store');

    Route::middleware(['permission:update admins'])
        ->get('/admins/{admin}/edit', [AdminController::class, 'edit'])
        ->name('admin.admins.edit');

    Route::middleware(['permission:update admins'])
        ->put('/admins/{admin}', [AdminController::class, 'update'])
        ->name('admin.admins.update');

    Route::middleware(['permission:delete admins'])
        ->delete('/admins/{admin}', [AdminController::class, 'destroy'])
        ->name('admin.admins.destroy');

    Route::get('/admins/{admin}', [AdminController::class, 'show'])
        ->name('admin.admins.show');
});

// ==========================
// Business Accounts Routes
// ==========================

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

    // 🔥 لازم يكون أول واحد قبل {id}
    Route::get('/business-accounts/deleted', [BusinessAccountController::class, 'deleted'])
        ->name('admin.business-accounts.deleted');

    Route::get('/business-accounts', [BusinessAccountController::class, 'index'])
        ->middleware('permission:view-business')
        ->name('admin.business-accounts.index');

    Route::get('/business-accounts/rejected', [BusinessAccountController::class, 'rejected'])
        ->middleware('permission:view-business')
        ->name('admin.business-accounts.rejected');

    Route::post('/business-accounts/approve', [BusinessAccountController::class, 'approve'])
        ->middleware('permission:approve-business')
        ->name('admin.business-accounts.approve');

    Route::post('/business-accounts/reject', [BusinessAccountController::class, 'reject'])
        ->middleware('permission:reject-business')
        ->name('admin.business-accounts.reject');

    Route::get('/business-accounts/{id}/edit', [BusinessAccountController::class, 'edit'])
        ->name('admin.business-accounts.edit');

    Route::put('/business-accounts/{id}', [BusinessAccountController::class, 'update'])
        ->name('admin.business-accounts.update');

    Route::get('/business-accounts/{id}/map', [BusinessAccountController::class, 'map'])
        ->name('admin.business-accounts.map');

    Route::get('/business-accounts/{id}', [BusinessAccountController::class, 'show'])
        ->middleware('permission:view-business')
        ->name('admin.business-accounts.show');

    Route::delete('/business-accounts/{id}', [BusinessAccountController::class, 'destroy'])
        ->name('admin.business-accounts.destroy');
        Route::post('/business-accounts/{id}/restore', [BusinessAccountController::class, 'restore'])
    ->name('admin.business-accounts.restore');


});


// ==========================
// Cities Routes (CLEAN VERSION)
// ==========================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth:admin'])
    ->group(function () {

        Route::prefix('cities')->name('cities.')->group(function () {

            Route::get('/', [CityController::class, 'index'])->name('index');
            Route::get('/create', [CityController::class, 'create'])->name('create');
            Route::post('/', [CityController::class, 'store'])->name('store');

            Route::get('/{city}/edit', [CityController::class, 'edit'])->name('edit');
            Route::put('/{city}', [CityController::class, 'update'])->name('update');
            Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');

            // Keep only enable/disable
            Route::post('/{city}/enable', [CityController::class, 'enable'])->name('enable');
            Route::post('/{city}/disable', [CityController::class, 'disable'])->name('disable');

            // REMOVE THIS:
            // Route::patch('/{city}/toggle', ...)
            // Route::post('/{city}/toggle', ...)
            // Route::get('/{city}/toggle', ...)
        });

    });


// ==========================
// Categories + Subcategories Routes
// ==========================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth:admin'])
    ->group(function () {

        // Subcategories
        Route::prefix('categories/sub')->name('categories.sub.')->group(function () {

            Route::get('/', [SubcategoryController::class, 'index'])->name('index');
            Route::get('/create', [SubcategoryController::class, 'create'])->name('create');
            Route::post('/', [SubcategoryController::class, 'store'])->name('store');

            Route::get('/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('edit');
            Route::put('/{subcategory}', [SubcategoryController::class, 'update'])->name('update');
            Route::delete('/{subcategory}', [SubcategoryController::class, 'destroy'])->name('destroy');

            Route::patch('/{subcategory}/enable', [SubcategoryController::class, 'enable'])->name('enable');
            Route::patch('/{subcategory}/disable', [SubcategoryController::class, 'disable'])->name('disable');
        });

        // Main Categories
        Route::prefix('categories')->name('categories.')->group(function () {

            Route::get('/{id}/fields', [CategoryController::class, 'manageFields'])->name('fields');

            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');

            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');

            Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        });

    });

// ==========================
// Dynamic Fields Routes
// ==========================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth:admin'])
    ->group(function () {

        Route::resource('fields', FieldController::class)->except(['show']);

        Route::prefix('fields/{field}')->name('fields.')->group(function () {
            Route::resource('options', FieldOptionController::class)->except(['show']);
        });
    });

// ==========================
// Services Routes
// ==========================
Route::prefix('admin')
    ->middleware(['web', 'auth:admin'])
    ->group(function () {


        Route::get('services', [AdminServiceController::class, 'index'])
            ->name('admin.services.index');

        Route::get('services/{id}', [AdminServiceController::class, 'show'])
            ->name('admin.services.show');

        Route::post('services/{id}/approve', [AdminServiceController::class, 'approve'])
            ->name('admin.services.approve');

        Route::post('services/{id}/reject', [AdminServiceController::class, 'reject'])
            ->name('admin.services.reject');

        Route::post('services/{id}/activate', [AdminServiceController::class, 'activate'])
            ->name('admin.services.activate');

        Route::post('services/{id}/deactivate', [AdminServiceController::class, 'deactivate'])
            ->name('admin.services.deactivate');

        Route::get('services/{id}/map', [AdminServiceController::class, 'map'])
            ->name('admin.services.map');
});
Route::prefix('admin')->middleware(['web', 'auth:admin'])->group(function () {

    // حفظ توكن الأدمن
    Route::post('/save-token', [FcmController::class, 'storeToken'])
        ->name('admin.save-token');

});

// إرسال إشعار (مفتوح لـ Postman)
Route::post('/admin/fcm/send', [FcmController::class, 'sendNotification'])
    ->withoutMiddleware(['web', 'auth:admin']);


use App\Http\Controllers\Admin\ConversationController;

Route::prefix('admin')->middleware(['web', 'auth:admin'])->group(function () {

    Route::prefix('conversations')->middleware('can:view-conversations')->group(function () {

        Route::get('/', [ConversationController::class, 'index'])
            ->name('admin.conversations.index');

        Route::get('/{id}', [ConversationController::class, 'show'])
            ->name('admin.conversations.show');
    });

});
use App\Http\Controllers\Admin\ReportController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/{id}', [ReportController::class, 'show'])->name('show');
        Route::post('/{id}/action', [ReportController::class, 'action'])->name('action');
    });

});

// ==========================
// Slider (FIXED VERSION)
// ==========================


Route::prefix('admin')
    ->middleware(['web', 'auth:admin'])
    ->name('admin.')
    ->group(function () {

        Route::prefix('slider')->name('slider.')->group(function () {

            Route::get('/', [SliderController::class, 'index'])->name('index');

            Route::post('/upload', [SliderController::class, 'upload'])->name('upload');

            Route::delete('/delete/{image}', [SliderController::class, 'delete'])->name('delete');


        });

    });
Route::get('admin/notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])
    ->name('admin.notifications.index');

Route::post('admin/notifications/{id}/read', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'markAsRead'])
    ->name('admin.notifications.read');

Route::post('admin/notifications/read-all', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'markAllAsRead'])
    ->name('admin.notifications.read_all');
