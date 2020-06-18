<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $user = new User;
        $user->name = "Miguel Angel Cornielly";
        $user->email = "mcornielly@gmail.com";
        $user->password = bcrypt('123456789');
        $user->save();

        factory(User::class, 25)->create();
    }
}
