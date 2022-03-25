<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::Create([
            'name'    => 'Abiola',
            'email'    => 'demo@demo.com',
            'password' => Hash::make('password')
        ]);
    }
}
