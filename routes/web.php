<?php

use App\Http\Controllers\DrugstoreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Landing Page (Public)
|--------------------------------------------------------------------------
| Redirect authenticated users to /home automatically.
| Guests will see the home.index (landing page).
*/
Route::get('/', [AdminController::class, 'home'])->name('landing');

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard Redirect
|--------------------------------------------------------------------------
| This route redirects the user to their appropriate dashboard
| based on usertype: admin, drugstore, or customer.
| Protected by Jetstream’s auth and email verification middleware.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        if (Auth::user()->usertype === 'customer') {
            return app()->make(\App\Http\Controllers\Customer\CustomerController::class)->index();
        }
        return app()->make(\App\Http\Controllers\AdminController::class)->index();
    })->name('home');
});

/*
|--------------------------------------------------------------------------
| Optional: Manual Logout Route (if not using Jetstream's built-in logout)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

//Admin Routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Customer Management
    Route::get('add-customer', [AdminController::class, 'createCustomer'])->name('admin.create');
    Route::post('store-customer', [AdminController::class, 'storeCustomer'])->name('admin.store');
    Route::get('view-customers', [AdminController::class, 'viewCustomers'])->name('admin.view');
    Route::delete('delete-customer/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.deleteCustomer');

    // Drugstore Management
    Route::get('/create-drugstore', [AdminController::class, 'createDrugstore'])->name('admin.drugstore.create');
    Route::post('/store-drugstore', [AdminController::class, 'storeDrugstore'])->name('admin.drugstore.store');
    Route::get('/view-drugstores', [DrugstoreController::class, 'adminViewDrugstores'])->name('admin.drugstore.view');
    Route::get('/edit-drugstore/{id}', [DrugstoreController::class, 'adminEditDrugstore'])->name('admin.drugstore.edit');
    Route::get('/view-drugstore/{id}', [DrugstoreController::class, 'adminViewSingleDrugstore'])->name('admin.drugstore.view.single');
    Route::put('/update-drugstore/{id}', [DrugstoreController::class, 'adminUpdateDrugstore'])->name('admin.drugstore.update');
    Route::delete('/delete-drugstore/{id}', [DrugstoreController::class, 'adminDeleteDrugstore'])->name('admin.drugstore.delete');
});

//Drugstore Routes
Route::middleware(['auth', 'isDrugstore'])->group(function () {
    // Dashboard
    Route::get('/drugstore/dashboard', [DrugstoreController::class, 'index'])->name('drugstore.dashboard');
    // Profile Routes
    Route::get('/drugstore/profile', [App\Http\Controllers\DrugstoreProfileController::class, 'show'])->name('drugstore.profile');
    Route::put('/drugstore/profile', [App\Http\Controllers\DrugstoreProfileController::class, 'update'])->name('drugstore.profile.update');
    // Order Management
    Route::post('orders/{id}/complete', [App\Http\Controllers\DrugstoreOrderController::class, 'complete'])->name('orders.complete');
    // Order Management
    Route::post('orders/{id}/approve', [App\Http\Controllers\DrugstoreOrderController::class, 'approve'])->name('orders.approve');
    Route::post('orders/{id}/reject', [App\Http\Controllers\DrugstoreOrderController::class, 'reject'])->name('orders.reject');


    // Show the add medicine form
    Route::get('add-medicine', [DrugstoreController::class, 'createMedicine'])->name('drugstore.create');

    // Handle the form submission
    Route::post('store-medicine', [DrugstoreController::class, 'storeMedicine'])->name('drugstore.store');

    // View Medicine Table
    Route::get('view-medicine', [DrugstoreController::class, 'viewMedicine'])->name('drugstore.view');

    //Edit Medicine
    Route::get('edit-medicine/{id}', [DrugstoreController::class, 'editMedicine'])->name('drugstore.editMedicine');

    //Update Medicine
    Route::put('update-medicine/{id}', [DrugstoreController::class, 'updateMedicine'])->name('drugstore.updateMedicine');

    // Delete Medicine
    Route::delete('/delete-medicine/{id}', [DrugstoreController::class, 'deleteMedicine'])->name('drugstore.deleteMedicine');
    Route::get('/get-sales-data', [DrugstoreController::class, 'getSalesData'])->name('drugstore.getSalesData');
    Route::get('/get-total-sales', [DrugstoreController::class, 'getTotalSales'])->name('drugstore.getTotalSales');
});

//Customer Routes
Route::middleware(['auth'])->group(function () {
    // Medicine Search Route
    Route::get('/search-medicines', [App\Http\Controllers\Customer\MedicineController::class, 'search'])->name('medicines.search');
    Route::get('/nearby-drugstores', [App\Http\Controllers\DrugstoreController::class, 'getNearbyDrugstores'])->name('drugstores.nearby');
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('customer.profile');
    Route::put('/profile/update', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('customer.profile.update');
    Route::put('/profile/update-password', [App\Http\Controllers\Customer\ProfileController::class, 'updatePassword'])->name('customer.profile.updatePassword');

    // Cart Routes
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');

    // Medicines
    Route::prefix('medicines')->name('medicines.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\MedicineController::class, 'index'])->name('index');
        Route::get('/categories', [App\Http\Controllers\Customer\MedicineController::class, 'categories'])->name('categories');
        Route::get('/low-stock', [App\Http\Controllers\Customer\MedicineController::class, 'lowStock'])->name('low-stock');
        Route::get('/expired', [App\Http\Controllers\Customer\MedicineController::class, 'expired'])->name('expired');
        Route::get('/{medicine}/edit', [App\Http\Controllers\Customer\MedicineController::class, 'edit'])->name('edit');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Customer\OrderController::class, 'store'])->name('store');
        Route::get('/pending', [App\Http\Controllers\Customer\OrderController::class, 'pending'])->name('pending');
        Route::get('/processing', [App\Http\Controllers\Customer\OrderController::class, 'processing'])->name('processing');
        Route::get('/completed', [App\Http\Controllers\Customer\OrderController::class, 'completed'])->name('completed');
        Route::get('/cancelled', [App\Http\Controllers\Customer\OrderController::class, 'cancelled'])->name('cancelled');
    });

    // Prescriptions
    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\PrescriptionController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Customer\PrescriptionController::class, 'store'])->name('store');
        Route::get('/pending', [App\Http\Controllers\Customer\PrescriptionController::class, 'pending'])->name('pending');
        Route::get('/approved', [App\Http\Controllers\Customer\PrescriptionController::class, 'approved'])->name('approved');
        Route::get('/rejected', [App\Http\Controllers\Customer\PrescriptionController::class, 'rejected'])->name('rejected');
        Route::get('/{prescription}', [App\Http\Controllers\Customer\PrescriptionController::class, 'show'])->name('show');
    });

    // Customers
    Route::get('/customers', [App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('customers.index');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [App\Http\Controllers\Customer\ReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [App\Http\Controllers\Customer\ReportController::class, 'inventory'])->name('inventory');
        Route::get('/customers', [App\Http\Controllers\Customer\ReportController::class, 'customers'])->name('customers');
    });

    // Settings
    Route::get('/settings', [App\Http\Controllers\Customer\SettingController::class, 'index'])->name('settings.index');

    // Cart Routes
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');

    // AI Chat Routes
    Route::post('/chat', [App\Http\Controllers\ChatController::class, 'chat'])->name('chat.message');
    Route::post('/chat/analyze-prescription', [App\Http\Controllers\ChatController::class, 'analyzePrescription'])->name('chat.analyze-prescription');
});
