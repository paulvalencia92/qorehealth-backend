<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install --force');

        User::create([
            'name' => 'Paul Valencia',
            'email' => 'apvalencia92@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
