<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Admin\FormSubmissionController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Frontend\CartController;

use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\FormSubmissionController as FrontendFormSubmissionController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;

// use App\Http\Controllers\Admin\CrudController;

// Route::get('/', [LoginController::class, 'loginForm'])->name('login');

// Customer
Route::middleware('redirect.role')->prefix('user')->group(function () {
    Route::get('login', [LoginController::class, 'showCustomerLogin'])->name('user.login');
    Route::post('login', [LoginController::class, 'customerLogin']);
});

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard');
        Route::get('/transactions', [FrontendDashboardController::class, 'transactions'])->name('transactions');

        Route::get('/invoice/{id}', [FrontendOrderController::class, 'invoice'])->name('frontend.invoice');
        Route::get('/invoice/{id}/download', [FrontendOrderController::class, 'invoiceDownload'])->name('frontend.invoice.download');
        Route::get('logout', [LoginController::class, 'userlogout'])->name('logout');
    });

// Route::middleware(['auth', 'role:user'])
Route::middleware(['auth'])
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        Route::post('/create-order', [CheckoutController::class, 'createOrder']);
        Route::post('/payment-intent', [CheckoutController::class, 'createStripeIntent']);
        Route::post('/confirm', [CheckoutController::class, 'confirmPayment']);
    });

Route::middleware(['auth', 'role:admin'])
    ->get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Admin
Route::prefix('admin')->middleware('redirect.role')->group(function () {
    Route::get('register', [RegisterController::class, 'registerForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
});

Route::post('admin/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role:admin'])->prefix('admin/{type}')->name('admin.')->group(function () {
//     Route::resource('tags', TagController::class)
//         ->parameters(['tags' => 'tag'])
//         ->scoped();
// });


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('/cruds', CrudController::class)->names('cruds');
    Route::get('/menus/sort', [MenuController::class, 'sort'])->name('menus.sort');
    Route::post('/menus/save', [MenuController::class, 'saveSortedMenu'])->name('menus.save');
    Route::post('/menus/type/', [MenuController::class, 'menus'])->name('menus.type');
    Route::resource('/menus', MenuController::class)->names('menus');
    // Route::post('filepond/upload', [CrudController::class, 'upload'])->name('filepond.upload');
    // Route::delete('filepond/revert', [CrudController::class, 'revert'])->name('filepond.revert');



    Route::group([
        'prefix' => '/media',
        'as' => 'media.',
    ], function () {
        Route::get('/', [MediaController::class, 'index'])->name('index'); // Media UI
        Route::post('/store', [MediaController::class, 'store'])->name('store'); // Upload file(s)
        Route::post('/store-folder', [MediaController::class, 'storeFolder'])->name('store.folder');
        Route::post('/move-folder', [MediaController::class, 'moveFolder'])->name('move.folder');
        Route::delete('/media/folder/{id}', [MediaController::class, 'deleteFolder'])->name('folder.delete');
        // Route::post('/create-folder', [MediaController::class, 'createFolder'])->name('create-folder'); // Make directory
        // Route::get('/browse', [MediaController::class, 'browse'])->name('browse'); // AJAX list contents
        // Route::get('/folder-tree', [MediaController::class, 'folderTree'])->name('folder-tree'); // AJAX sidebar

        // Route::get('/download', [MediaController::class, 'downloadImage'])->name('download'); // Download file
        Route::post('/delete', [MediaController::class, 'delete'])->name('delete'); // Delete selected
    });

    // Route::resource('forms', FormBuilderController::class);
    // Route::get('forms/{form}/builder', [FormBuilderController::class, 'builder'])->name('forms.builder');
    // Route::post('forms/{form}/builder', [FormBuilderController::class, 'saveBuilder'])->name('forms.builder.save');
    

    // Route::prefix('blogs')->name('blogs.')->group(function () {
    //     Route::resource('tags', TagController::class)
    //         ->parameters(['tags' => 'tag'])
    //         ->names('tags')
    //         ->scoped();
    // });
    Route::resource('blogs', BlogController::class)->names('blogs');
    // Route::resource('pages', PageController::class);

    // Page builder routes nested under pages:
    // Route::prefix('pages/{page}')->group(function () {
    //     Route::get('builder', [PageBuilderController::class, 'index'])->name('pages.builder');
    //     Route::post('builder/store', [PageBuilderController::class, 'store'])->name('pages.builder.store');
    //     Route::post('add-block', [PageBuilderController::class, 'addBlock'])->name('pages.builder.add.block');
    //     Route::post('builder/save', [PageBuilderController::class, 'save'])->name('pages.builder.save');
    // });

    Route::resource('payment-gateways', PaymentGatewayController::class);

    // Route::prefix('forms/{form}')->group(function () {
    //     Route::get('/submissions', [FormSubmissionController::class, 'index'])->name('forms.submissions.index');
    //     Route::get('/submissions/{submission}', [FormSubmissionController::class, 'show'])->name('forms.submissions.show');
    //     Route::delete('/submissions/{submission}', [FormSubmissionController::class, 'destroy'])->name('forms.submissions.destroy');
    // });

    Route::resource('tags', TagController::class);
    Route::resource('sliders', SliderController::class);
});

Route::get('/', [HomeController::class, 'index']);

// Route::post('/forms/{form}/submit', [FrontendFormSubmissionController::class, 'store'])->name('forms.submit');
// Route::get('/pages/{slug}', [FrontendPageController::class, 'show'])
//     ->name('frontend.pages.show');
// Route::middleware(['auth'])->get('/page-preview/{slug}', [FrontendPageController::class, 'preview'])
//     ->name('frontend.pages.preview');
Route::get('/blogs/{slug}', [FrontendPageController::class, 'blog'])
    ->name('frontend.blog.show');

Route::get('/test', [TestController::class, 'index']);

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('brands', BrandController::class);
    Route::resource('tags', TagController::class);
    Route::prefix('products')->as('products.')->group(function () {
        Route::resource('attributes', AttributeController::class)->names('attributes');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('{product}/variants', ProductVariantController::class)->names('variants');
    });
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);

    Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    Route::get('/invoice/{id}/download', [OrderController::class, 'invoiceDownload'])->name('invoice.download');
});




Route::get('/products', [FrontendProductController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('frontend.products.show');

Route::get('/categories/{slug}', [FrontendPageController::class, 'category'])->name('frontend.categories.show');
Route::get('/categories', [FrontendPageController::class, 'categories'])->name('frontend.categories.index');


// Cart routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('frontend.cart.index');
    Route::post('add', [CartController::class, 'add'])->name('frontend.cart.add');
    Route::post('add-multiple', [CartController::class, 'addMultiple'])->name('frontend.cart.add-multiple');
    Route::post('remove', [CartController::class, 'remove'])->name('frontend.cart.remove');
    Route::post('update', [CartController::class, 'update'])->name('frontend.cart.update');
});

Route::get('/pc-builder', [FrontendProductController::class, 'pcBuilder'])->name('frontend.pc_builder');
Route::get('/cart', [CartController::class, 'cart'])->name('frontend.cart.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('frontend.checkout.index')->middleware('customer');
Route::get('/payment-complete', [CheckoutController::class, 'complete'])->name('frontend.payment.complete');



Route::middleware(['auth', 'role:user'])
    ->get('/orders/{id}/show', [FrontendOrderController::class, 'show'])->name('frontend.orders.show');
