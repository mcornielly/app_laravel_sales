<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

        // Super Admin
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrador']);
        $adminRole->givePermissionTo(['view dashboard']);
        $adminRole->givePermissionTo(['create divisa','view divisa','detail divisa','update divisa','delete divisa']);
        $adminRole->givePermissionTo(['view storage']);
        $adminRole->givePermissionTo(['create category','view category','detail category','update category','delete category']);
        $adminRole->givePermissionTo(['create product','view product','detail product','update product','delete product']);
        $adminRole->givePermissionTo(['create list','view list','detail list','update list','delete list']);
        $adminRole->givePermissionTo(['view shopping']);
        $adminRole->givePermissionTo(['create income','view income','detail income','update income','delete income']);
        $adminRole->givePermissionTo(['create provider','view provider','detail provider','update provider','delete provider']);
        $adminRole->givePermissionTo(['view sales']);
        $adminRole->givePermissionTo(['create sale','view sale','detail sale','update sale','delete sale']);
        $adminRole->givePermissionTo(['create customer','view customer','detail customer','update customer','delete customer']);
        $adminRole->givePermissionTo(['view reports']);
        $adminRole->givePermissionTo(['view income report','detail income report']);
        $adminRole->givePermissionTo(['view sale report','detail sale report']);
        $adminRole->givePermissionTo(['view access']);
        $adminRole->givePermissionTo(['create user','view user','detail user','update user','delete user']);
        $adminRole->givePermissionTo(['create role','view role','detail role','update role','delete role']);
        
        // Vendedor
        $salerRole = Role::create(['name' => 'saler', 'display_name' => 'Vendedor']);
        $salerRole->givePermissionTo(['view dashboard']);
        $salerRole->givePermissionTo(['view storage']);
        $salerRole->givePermissionTo(['create list','view list','detail list','update list','delete list']);
        $salerRole->givePermissionTo(['view sales']);
        $salerRole->givePermissionTo(['create sale','view sale','detail sale','update sale','delete sale']);
        $salerRole->givePermissionTo(['create customer','view customer','detail customer','update customer','delete customer']);
        
        // Almacén
        $storerRole = Role::create(['name' => 'storage', 'display_name' => 'Almacen']);
        $storerRole->givePermissionTo(['view dashboard']);
        $storerRole->givePermissionTo(['view storage']);
        $storerRole->givePermissionTo(['create category','view category','detail category','update category','delete category']);
        $storerRole->givePermissionTo(['create product','view product','detail product','update product','delete product']);
        $storerRole->givePermissionTo(['view shopping']);
        $storerRole->givePermissionTo(['create income','view income','detail income','update income','delete income']);
        $storerRole->givePermissionTo(['create customer','view customer','detail customer','update customer','delete customer']);
        $storerRole->givePermissionTo(['view reports']);
        $storerRole->givePermissionTo(['view income report','detail income report']);
        $storerRole->givePermissionTo(['view sale report','detail sale report']);

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
