<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Admin";
        $user->email = "info@damianpuister.nl";
        $user->password = bcrypt('secret');
        $user->is_admin = true;
        $user->save();
    }
}
