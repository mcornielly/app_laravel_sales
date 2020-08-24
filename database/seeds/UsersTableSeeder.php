<?php

use App\User;
use Illuminate\Database\Seeder;
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

        $adminRole = Role::create(['name' => 'Administrador']);
        $salerRole = Role::create(['name' => 'Vendedor']);
        $storerRole = Role::create(['name' => 'Almacen']);

        $admin = new User;
        $admin->name = "Miguel Angel Cornielly";
        $admin->email = "mcornielly@gmail.com";
        $admin->password = bcrypt('123456789');
        $admin->save();

        $admin->assignRole($adminRole);

        $saler = new User;
        $saler->name = "Joshua Miguel Cornielly";
        $saler->email = "jcornielly@gmail.com";
        $saler->password = bcrypt('123456789');
        $saler->save();

        $saler->assignRole($salerRole);

        $storer = new User;
        $storer->name = "Magda Martinez";
        $storer->email = "mmartinez@gmail.com";
        $storer->password = bcrypt('123456789');
        $storer->save();

        $storer->assignRole($storerRole);

    }
}
