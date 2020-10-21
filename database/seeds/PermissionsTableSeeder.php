<?php
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        // Divisa
        $createDivisa = Permission::create(['name' => 'create divisa', 'display_name' => 'Crear Cotización']);
        $viewDivisa = Permission::create(['name' => 'view divisa','display_name' => 'Ver Cotización']);
        $updateDivisa = Permission::create(['name' => 'update divisa', 'display_name' => 'Actualizar Cotización']);
        $deleteDivisa = Permission::create(['name' => 'delete divisa', 'display_name' => 'Eliminar Cotización']);
        // Categorías
        $createCategory = Permission::create(['name' => 'create category', 'display_name' => 'Crear Categoría']);
        $viewCategory = Permission::create(['name' => 'view category','display_name' => 'Ver Categoría']);
        $updateCategory = Permission::create(['name' => 'update category', 'display_name' => 'Actualizar Categoría']);
        $deleteCategory = Permission::create(['name' => 'delete category', 'display_name' => 'Eliminar Categoría']);
        // Productos
        $createProduct = Permission::create(['name' => 'create product', 'display_name' => 'Crear Producto']);
        $viewProduct = Permission::create(['name' => 'view product','display_name' => 'Ver Producto']);
        $updateProduct = Permission::create(['name' => 'update product', 'display_name' => 'Actualizar Producto']);
        $deleteProduct = Permission::create(['name' => 'delete product', 'display_name' => 'Eliminar Producto']);
        // Lista de Productos
        $createListProduct = Permission::create(['name' => 'create list', 'display_name' => 'Crear list']);
        $viewListProduct = Permission::create(['name' => 'view list','display_name' => 'Ver list']);
        $updateListProduct = Permission::create(['name' => 'update list', 'display_name' => 'Actualizar list']);
        $deleteListProduct = Permission::create(['name' => 'delete list', 'display_name' => 'Eliminar list']);

        // $adminRole = User::find(2);
        // $adminRole->givePermissionsTo($viewDivisa);
         
    }
}
