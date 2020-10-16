<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::truncate();
        User::truncate();

        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrador']);
        $salerRole = Role::create(['name' => 'seler', 'display_name' => 'Vendedor']);
        $storerRole = Role::create(['name' => 'storage', 'display_name' => 'Almacen']);

        $admin = new User;
        $admin->name = "Miguel Angel Cornielly";
        $admin->email = "mcornielly@gmail.com";
        $admin->password = Hash::make('123456789');
        $admin->save();

        $admin->assignRole($adminRole);

        $saler = new User;
        $saler->name = "Joshua Miguel Cornielly";
        $saler->email = "jcornielly@gmail.com";
        $saler->password = Hash::make('123456789');
        $saler->save();

        $saler->assignRole($salerRole);

        $storer = new User;
        $storer->name = "Magda Martinez";
        $storer->email = "mmartinez@gmail.com";
        $storer->password = Hash::make('123456789');
        $storer->save();

        $storer->assignRole($storerRole);

    }
}
