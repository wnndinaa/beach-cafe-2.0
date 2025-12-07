<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Models\Feedback;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;


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
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User list management routes
    Route::get('/profile/list', [ProfileController::class, 'viewListofUsers'])->name('profile.index');
    Route::delete('/profile/list/delete/{id}', [ProfileController::class, 'deleteUser'])->name('profile.delete');

    // Role editing routes
    Route::get('/profile/list/edit-role/{id}', [ProfileController::class, 'editRole'])->name('profile.editRole');
    Route::patch('/profile/list/edit-role/{id}', [ProfileController::class, 'updateRole'])->name('profile.updateRole'); // Changed name to avoid duplication
  
  Route::get('/list_of_feedback/{id}', [FeedbackController::class, 'viewListOFeedback'])->name('view_all_feedback');
  Route::get('/add_feedback/{menu_id}', [FeedbackController::class, 'viewAddFeedback'])->name('view_add_Feedback');
  Route::post('/add_feedback/create', [FeedbackController::class, 'createFeedback'])->name('create_feedback');
  Route::get('/menu', [MenuController::class, 'index'])->name('menu');
  
  // MODULE FEEDBACK
Route::get('/dummydisplay', [FeedbackController::class, 'displaydummy'])->name('dummydisplay');
Route::get('/list_of_feedback/{id}', [FeedbackController::class, 'viewListOFeedback'])->name('view_all_feedback');
Route::get('/feedback_details/{id}', [FeedbackController::class, 'viewFeedbackDetails'])->name('view_feedback_details');
Route::get('/edit_feedback_details/{id}', [FeedbackController::class, 'viewEditFeedback'])->name('edit_feedback_details');
Route::get('/add_feedback/{menu_id}', [FeedbackController::class, 'viewAddFeedback'])->name('view_add_Feedback');
Route::post('/add_feedback/create', [FeedbackController::class, 'createFeedback'])->name('create_feedback');

// inventory
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
// Route for filtering inventory data
Route::get('/inventory/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
Route::middleware('auth')->group(function () {
});

//customer menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

//staff menu
//   MODULE MENU
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/staff-menu', [MenuController::class, 'staffMenu']);
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
Route::get('/staff-menu', [MenuController::class, 'staffMenu'])->name('staff-menu');
Route::get('/add-menu', [MenuController::class, 'addMenu'])->name('add-menu');



//order

// Route::get('/orderCustomization', [OrderController::class, 'showCustomization'])->name('customize.order');

Route::get('/orderCustomization/{menu}', [OrderController::class, 'showCustomization'])->name('customize.order');
Route::post('/order/store', [OrderController::class, 'storeToCart'])->name('order.store');
Route::get('/deleteCart/{order}', [OrderController::class, 'destroyOrder'])->name('order.destroy');
Route::get('/cartList', [OrderController::class, 'showCartList'])->name('order.cart');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/order-confirmation', [OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');
Route::post('/confirm-order/{order}', [OrderController::class, 'confirmOrder'])->name('order.confirm');
Route::post('/confirm-order/{orderId}', [OrderController::class, 'confirmOrder'])->name('confirmOrder');
Route::get('/order-status/{orderId}', [OrderController::class, 'orderStatus'])->name('orderStatus');
Route::get('/editCart/{orderId}/{menuId}', [OrderController::class, 'updateCustomization'])->name('order.edit');
Route::put('/order/{order}', [OrderController::class, 'update'])->name('order.update');
Route::get('/order-history', [OrderController::class, 'showHistory'])->name('order.history');
Route::post('/reorder/{order}', [OrderController::class, 'reorder'])->name('order.reorder');
Route::delete('/reorders/{order}', [OrderController::class, 'reorderDestroy'])->name('reorder.delete');
Route::get('/invoice/download/{order_id}', [OrderController::class, 'downloadInvoice'])->name('invoice.download');
Route::get('/orders/{id}/download-invoice', [OrderController::class, 'printInvoice'])->name('order.download');

//staff order
// Route to display list of orders
Route::get('/staff-orderList', [OrderController::class, 'showOrderList'])->name('staff.ordersIndex');
Route::get('/staff/orders/{id}', [OrderController::class, 'showOrder'])->name('staff.orderDetails');

Route::patch('/update_feedback/feedback/{id}', [FeedbackController::class, 'updateFeedback'])->name('update_feedback');
Route::delete('/delete_feedback/{id}', [FeedbackController::class, 'deleteFeedback'])->name('delete_feedback');
});

require __DIR__.'/auth.php';
