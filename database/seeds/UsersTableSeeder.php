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
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrador','description' => 'El Usuario Administrador tiene el control total en la aplicación.']);
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
        $salerRole = Role::create(['name' => 'saler', 'display_name' => 'Vendedor','description' => 'El Usuario Vendedor tiene el control en el porceso de ventas y reportes.']);
        $salerRole->givePermissionTo(['view dashboard']);
        $salerRole->givePermissionTo(['view storage']);
        $salerRole->givePermissionTo(['create list','view list','detail list','update list','delete list']);
        $salerRole->givePermissionTo(['view sales']);
        $salerRole->givePermissionTo(['create sale','view sale','detail sale','update sale','delete sale']);
        $salerRole->givePermissionTo(['create customer','view customer','detail customer','update customer','delete customer']);
        
        // Almacén
        $storerRole = Role::create(['name' => 'storage', 'display_name' => 'Almacen','description' => 'El Usuario Almacén tiene el control a los menú de ingresos, egresos y reportes.']);
        $storerRole->givePermissionTo(['view dashboard']);
        $storerRole->givePermissionTo(['view storage']);
        $storerRole->givePermissionTo(['create category','view category','detail category','update category','delete category']);
        $storerRole->givePermissionTo(['create product','view product','detail product','update product','delete product']);
        $storerRole->givePermissionTo(['view shopping']);
        $storerRole->givePermissionTo(['create income','view income','detail income','update income','delete income']);
        $storerRole->givePermissionTo(['create provider','view provider','detail provider','update provider','delete provider']);
        $storerRole->givePermissionTo(['view reports']);
        $storerRole->givePermissionTo(['view income report','detail income report']);
        $storerRole->givePermissionTo(['view sale report','detail sale report']);

        $admin = new User;
        $admin->id = 1;
        $admin->name = "Miguel Angel Cornielly";
        $admin->email = "mcornielly@gmail.com";
        $admin->password = '123456789';
        // $admin->password = Hash::make('123456789');
        $admin->assignRole($adminRole->name);
        $admin->save();

        

        $saler = new User;
        $saler->id = 2;
        $saler->name = "Joshua Miguel Cornielly";
        $saler->email = "jcornielly@gmail.com";
        $saler->password = '123456789';
        // $saler->password = Hash::make('123456789');
        $saler->assignRole($salerRole->name);
        $saler->save();


        $storer = new User;
        $storer->id = 3;
        $storer->name = "Magda Martinez";
        $storer->email = "mmartinez@gmail.com";
        $storer->password = '123456789';
        // $storer->password = Hash::make('123456789');
        $storer->assignRole($storerRole->name);
        $storer->save();


    }
}
