<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Robb Jones',
            'email' => 'a@a',
            'password' => Hash::make('aaaaaa'),
            'phone' => '+7-913-324-95-46',
        ]);

        User::create([
            'name' => 'John Persimonn',
            'email' => 's@s',
            'password' => Hash::make('ssssss'),
            'phone' => '+7-926-324-95-79',
        ]);

        User::create([
            'name' => 'Yulia Pesochkina',
            'email' => 'd@d',
            'password' => Hash::make('dddddd'),
            'phone' => '+7-925-324-55-16',
        ]);

        $user = User::where('name', 'Robb Jones')->first();
        $user->assignRole('Admin');
    }
}
