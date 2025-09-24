<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // cek apakah sudah ada
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('123456'), // hash password
                'is_admin' => 1,                    // pastikan ada kolom ini
            ]
        );
    }
}
