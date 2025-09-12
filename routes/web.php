<?php

use App\Http\Controllers\FieldworkStatusController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RegionController;
use App\Models\Branch;use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
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

    // ✅ Generate ID max 25 char (sesuai migration)
    $id         = Str::random(25);
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

// crud
Route::resource('region', RegionController::class);
Route::resource('branch', BranchController::class);
Route::resource('fieldwork_statuses', FieldworkStatusController::class);

