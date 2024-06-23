<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = new User();
        $admin->name = 'Administrador';
        $admin->email = 'admin@interesse.com';
        $admin->password = Hash::make('interesseadmin');
        $admin->is_admin = true;
        $admin->save();
    }
}
