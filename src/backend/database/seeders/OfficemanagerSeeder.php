<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OfficemanagerSeeder extends Seeder
{
    public function run(): void
    {
            if (!User::where('rol', 'officemanager')->exists()) {
                User::create([
                    'first_name' => 'Admin',
                    'last_name' => 'van Geoprofs',
                    'email' => 'adminGeoprofs@mail.com', 
                    'password' => Hash::make('12345678'), 
                    'rol' => 'officemanager',
                ]);
            }
    }
}
