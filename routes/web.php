<?php
use Illuminate\Support\Facades\Route;
// PUBLIC
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PublicDesignerController;
use App\Http\Controllers\DashboardController;

// CUSTOMER alias
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\ProfileController as CustomerProfile;
use App\Http\Controllers\Customer\CartController as CustomerCart;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckout;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\RatingController as CustomerRating;
use App\Http\Controllers\Customer\CustomRequestController as CustomerCustom;

// DESIGNER alias
use App\Http\Controllers\Designer\DashboardController as DesignerDashboard;
use App\Http\Controllers\Designer\ProfileController as DesignerProfile;
use App\Http\Controllers\Designer\DesignController as DesignerDesign;
use App\Http\Controllers\Designer\DesignMediaController as DesignerDesignMedia;
use App\Http\Controllers\Designer\OrderController as DesignerOrder;
use App\Http\Controllers\Designer\CustomRequestController as DesignerCustom;

// ADMIN alias
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\DesignController as AdminDesign;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\SettingController;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\TestMail;

// PUBLIC
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/designs', [CatalogController::class, 'index'])->name('designs.index');
Route::get('/designs/{slug}', [CatalogController::class, 'show'])->name('designs.show');
Route::get('/designer/{id}', [PublicDesignerController::class, 'show'])->whereNumber('id')->name('public.designer');
Route::view('/about', 'about')->name('about');

// REDIRECTOR
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/test-mail', function () {
//     Mail::to('test@example.com')->send(new TestMail('Ini pesan uji kirim.'));
//     return 'Terkirim. Cek inbox Mailtrap kamu.';
// });

// CUSTOMER
Route::middleware(['auth','role:customer'])->prefix('customer')->as('customer.')->group(function () {
  Route::get('/', [CustomerDashboard::class, 'index'])->name('dashboard');
  Route::get('profile', [CustomerProfile::class, 'edit'])->name('profile.edit');
  Route::put('profile', [CustomerProfile::class, 'update'])->name('profile.update');

  Route::get('cart', [CustomerCart::class, 'index'])->name('cart.index');
  Route::post('cart/{design}', [CustomerCart::class, 'store'])->name('cart.store');
  Route::delete('cart/{item}', [CustomerCart::class, 'destroy'])->name('cart.destroy');

  Route::post('checkout', [CustomerCheckout::class, 'store'])->name('checkout.store');

  Route::resource('orders', CustomerOrder::class)->only(['index','show']);
  Route::post('orders/{order}/payment-proof', [CustomerOrder::class,'uploadProof'])->name('orders.proof');
  Route::get('orders/deliverables/{deliverable}/download',
  [CustomerOrder::class,'downloadDeliverable']
    )->name('orders.deliverables.download');

    Route::post('orders/items/{item}/accept',   [CustomerOrder::class,'acceptItem'])->name('orders.items.accept');
    Route::post('orders/items/{item}/revision', [CustomerOrder::class,'requestRevision'])->name('orders.items.revision');

//   Route::post('orders/{order}/comment', [CustomerOrder::class,'comment'])->name('orders.comment');
    Route::post('orders/{order}/rating', [CustomerRating::class,'store'])->name('orders.rating');

    Route::resource('custom-requests', CustomerCustom::class)->only(['index','create','store','show']);
    Route::post('custom-requests/{custom_request}/accept-quote', [CustomerCustom::class,'acceptQuote'])
    ->name('custom-requests.accept-quote');
    Route::get('browse-designs', [CatalogController::class, 'indexCustomer'])->name('browse-designs');
    Route::post('orders/{order}/confirm-delivered', [CustomerOrder::class,'confirmDelivered'])->name('orders.confirm-delivered');

    // cancel order (customer)
Route::post('orders/{order}/cancel', [CustomerOrder::class, 'cancel'])
    ->name('orders.cancel');


});

// DESIGNER
Route::middleware(['auth','role:designer'])->prefix('designer')->as('designer.')->group(function () {
  Route::get('/', [DesignerDashboard::class, 'index'])->name('dashboard');
  Route::get('profile', [DesignerProfile::class, 'edit'])->name('profile.edit');
  Route::put('profile', [DesignerProfile::class, 'update'])->name('profile.update');

  Route::resource('designs', DesignerDesign::class); // CRUD
  Route::post('designs/{design}/media', [DesignerDesignMedia::class,'store'])->name('designs.media.store');
  Route::delete('designs/media/{media}', [DesignerDesignMedia::class,'destroy'])->name('designs.media.destroy');

  Route::resource('orders', DesignerOrder::class)->only(['index','show','update']);
  Route::post('orders/{order}/confirm-payment', [DesignerOrder::class,'confirmPayment'])->name('orders.confirm');
  Route::post('orders/{orderItem}/deliverable', [DesignerOrder::class,'uploadDeliverable'])->name('orders.deliverable');
  Route::post('orders/items/{item}/comment', [DesignerOrder::class,'commentItem'])
  ->name('orders.items.comment');
    // (opsional) Designer paksa item jadi revised + catatan
Route::post('orders/items/{item}/mark-revised', [DesignerOrder::class,'markRevised'])
  ->name('orders.items.mark-revised');

  // DESIGNER
Route::resource('custom-requests', DesignerCustom::class)->only(['index','show']);
Route::post('custom-requests/{custom_request}/quote',    [DesignerCustom::class,'quote'])->name('custom-requests.quote');
Route::post('custom-requests/{custom_request}/decision', [DesignerCustom::class,'decision'])->name('custom-requests.decision');

Route::post('orders/{order}/shipping', [DesignerOrder::class,'updateShipping'])->name('orders.shipping.update');
Route::post('orders/{order}/mark-shipped', [DesignerOrder::class,'markShipped'])->name('orders.mark-shipped');

Route::post('orders/{order}/shipping', [DesignerOrder::class,'updateShipping'])->name('orders.shipping');
Route::post('orders/{order}/mark-shipped', [DesignerOrder::class,'markShipped'])->name('orders.mark-shipped');


});

// ADMIN
Route::middleware(['auth','role:admin'])->prefix('admin')->as('admin.')->group(function () {
  Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
  Route::resource('users', AdminUser::class);
  Route::resource('categories', AdminCategory::class);
  Route::resource('designs', AdminDesign::class)->only(['index','show','update','destroy']);
  Route::resource('orders', AdminOrder::class)->only(['index','show','update']);

  Route::get('settings/content', [SettingController::class,'editContent'])->name('settings.content');
    Route::put('settings/content', [SettingController::class,'updateContent'])->name('settings.content.update');
});


require __DIR__.'/auth.php';
