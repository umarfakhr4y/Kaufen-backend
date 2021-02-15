<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@role.test',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $admin->assignRole('admin');

        $admin2 = User::create([
            'name' => 'Kaufen Market',
            'email' => 'kaufen.market@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('100'),
        ]);

        $admin2->assignRole('admin');

        $anggota = User::create([
            'name' => 'Anggota',
            'email' => 'anggota@role.test',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $anggota->assignRole('anggota');

        $penjual = User::create([
            'name' => 'Penjual',
            'email' => 'penjual@role.test',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $penjual->assignRole('penjual');
    }
}
