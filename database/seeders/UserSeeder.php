<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'Invitado';
        $user->email = 'invitado@interesse.com';
        $user->password = Hash::make('interesseinvitado');
        $user->is_admin = false;
        $user->save();
    }
}
