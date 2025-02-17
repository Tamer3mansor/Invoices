<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoiceAttechmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
return view('auth.login');
});

Route::get('/inactive', function () {
return view('users.inactive');
});

// ✅ Correct middleware order
Route::get('/home', function () {
return view('index');
})->middleware(['auth', 'verified', 'check'])->name('dashboard');

Route::middleware(['auth', 'check'])->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('products', ProductController::class);
Route::resource('attachment', InvoiceAttechmentsController::class);
Route::resource('sections', SectionController::class);
Route::resource('invoices', InvoicesController::class);
Route::resource('Archive', InvoiceAchiveController::class);

Route::get('attachment/download/{file_name}/{invoice_number}', [InvoiceAttechmentsController::class,
'file'])->name('attachment.file');
Route::get('attachment/view/{file_name}/{invoice_number}', [InvoiceAttechmentsController::class,
'download'])->name('attachment.download');
Route::get('/section/{id}', [InvoicesController::class, 'get_products']);
Route::get('invoices/details/{id}', [InvoicesController::class, 'details'])->name("invoices.details");
Route::get('invoices/status_show/{id}', [InvoicesController::class, 'status_show'])->name("invoices.status");
Route::put('invoices/status_update/{invoice}', [InvoicesController::class,
'status_update'])->name("invoices.status_update");
Route::get('paid', [InvoicesController::class, 'paid'])->name("invoices.paid");
Route::get('un_paid', [InvoicesController::class, 'un_paid'])->name("invoices.un_paid");
Route::get('p_paid', [InvoicesController::class, 'p_paid'])->name("invoices.p_paid");
Route::get('Print_invoice/{id}', [InvoicesController::class, 'print_invoice']);
});

require __DIR__ . '/auth.php';
