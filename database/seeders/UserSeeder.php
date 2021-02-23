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
        $damar = User::create([                                       // Dmaar
            'name' => 'damar ardian',
            'email' => 'damar.rizki212@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $damar->assignRole('admin');

        $umar = User::create([                                        // Umar
            'name' => 'umar fakhry',
            'email' => 'umarfakhr1y@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $umar->assignRole('admin');

        $baim = User::create([                                        // Baim
            'name' => 'ibraim ahmad',
            'email' => 'ibrahimahmad8896@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $baim->assignRole('admin');

        $akmal = User::create([                                        // Trex
            'name' => 'akmal ilham',
            'email' => 'akmalilhamstp@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $akmal->assignRole('admin');

        $farhan = User::create([                                        // bombom
            'name' => 'farhan khosyi',
            'email' => 'farhankhosyi@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $farhan->assignRole('admin');

        $padlu = User::create([                                         // bapak
            'name' => 'hanif fadhlu',
            'email' => 'hanifflu12@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $padlu->assignRole('admin');

        $bongga = User::create([                                        // bongga
            'name' => 'erlangga adithya',
            'email' => 'erlanggadithya97@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $bongga->assignRole('admin');

        $ebed = User::create([                                          // ebed
            'name' => 'hasan munif',
            'email' => 'm.hasanmunif@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $ebed->assignRole('admin');

        $kaufen = User::create([                                          // kaufen
            'name' => 'kaufen market',
            'email' => 'kaufen.market@gmail.com',
            "email_verified_at" => now()->timezone('Asia/Jakarta'),
            'password' => Hash::make('123456789'),
        ]);

        $kaufen->assignRole('admin');

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
