<?php

use App\Http\Controllers\FieldworkStatusController;

use App\Http\Controllers\FieldworkController;

use App\Http\Controllers\FieldworkCategoryController;

use App\Http\Controllers\UserPhoneController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RegionController;
use App\Http\Middleware\Admin;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FieldworkExportController;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Cari user atau buat baru
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name'     => $googleUser->getName(),
            'password' => bcrypt(Str::random(16)),
        ]
    );

    auth()->login($user);

    // ✅ Generate ID max 11 char (sesuai migration)
    $id         = Str::random(11);
    $tokenValue = Str::random(32);

    DB::table('tokens')->insert([
        'id'         => $id,
        'value'      => $tokenValue,
        'is_revoked' => 0, // tinyint/boolean default false
        'user_id'    => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    session(['login_token' => $tokenValue]);

    return redirect('/home');
});


// routes/web.php
Route::get('/branches-by-region/{region_id}', [App\Http\Controllers\BranchController::class, 'getByRegion']);


// crud
Route::resource('region', RegionController::class);
Route::resource('branch', BranchController::class);
Route::resource('fieldwork_statuses', FieldworkStatusController::class);
Route::resource('fieldwork_category', FieldworkCategoryController::class);
Route::resource('fieldwork', FieldworkController::class);
Route::resource('userphone', UserPhoneController::class);
Route::resource('listuser', App\Http\Controllers\UserController::class);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Fieldwork Export
Route::get('/export', [FieldworkExportController::class, 'index'])->name('fieldwork.export');
//excel
Route::get('/export/excel', [FieldworkExportController::class, 'excel'])->name('fieldwork.export.excel');
//pdf
Route::get('/export/pdf', [FieldworkExportController::class, 'pdf'])->name('fieldwork.export.pdf');

Route::get('/profile', [UserProfileController::class, 'myProfile'])->name('profile');
Route::get('/profile/create', [UserProfileController::class, 'create'])->name('profile.create');
Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
