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
        $detailDivisa = Permission::create(['name' => 'detail divisa','display_name' => 'Detalle Cotización']);
        $updateDivisa = Permission::create(['name' => 'update divisa', 'display_name' => 'Actualizar Cotización']);
        $deleteDivisa = Permission::create(['name' => 'delete divisa', 'display_name' => 'Eliminar Cotización']);
        // Categorías
        $createCategory = Permission::create(['name' => 'create category', 'display_name' => 'Crear Categoría']);
        $viewCategory = Permission::create(['name' => 'view category','display_name' => 'Ver Categoría']);
        $detailCategory = Permission::create(['name' => 'detail category','display_name' => 'Detalle Categoría']);
        $updateCategory = Permission::create(['name' => 'update category', 'display_name' => 'Actualizar Categoría']);
        $deleteCategory = Permission::create(['name' => 'delete category', 'display_name' => 'Eliminar Categoría']);
        // Productos
        $createProduct = Permission::create(['name' => 'create product', 'display_name' => 'Crear Producto']);
        $viewProduct = Permission::create(['name' => 'view product','display_name' => 'Ver Producto']);
        $detailProduct = Permission::create(['name' => 'detail product','display_name' => 'Detalle Producto']);
        $updateProduct = Permission::create(['name' => 'update product', 'display_name' => 'Actualizar Producto']);
        $deleteProduct = Permission::create(['name' => 'delete product', 'display_name' => 'Eliminar Producto']);
        // Lista de Productos
        $createListProduct = Permission::create(['name' => 'create list', 'display_name' => 'Crear list']);
        $viewListProduct = Permission::create(['name' => 'view list','display_name' => 'Ver list']);
        $detailListProduct = Permission::create(['name' => 'detail list','display_name' => 'Detalle list']);
        $updateListProduct = Permission::create(['name' => 'update list', 'display_name' => 'Actualizar list']);
        $deleteListProduct = Permission::create(['name' => 'delete list', 'display_name' => 'Eliminar list']);
        // Ingresos
        $createIncome = Permission::create(['name' => 'create income', 'display_name' => 'Crear Ingreso']);
        $viewIncome = Permission::create(['name' => 'view income','display_name' => 'Ver Ingreso']);
        $detailIncome = Permission::create(['name' => 'detail income','display_name' => 'detail Ingreso']);
        $updateIncome = Permission::create(['name' => 'update income', 'display_name' => 'Actualizar Ingreso']);
        $deleteIncome = Permission::create(['name' => 'delete income', 'display_name' => 'Eliminar Ingreso']);
        // Proveeedores
        $createProvider = Permission::create(['name' => 'create provider', 'display_name' => 'Crear Proveedor']);
        $viewProvider = Permission::create(['name' => 'view provider','display_name' => 'Ver Proveedor']);
        $detailProvider = Permission::create(['name' => 'detail provider','display_name' => 'Detalle Proveedor']);
        $updateProvider = Permission::create(['name' => 'update provider', 'display_name' => 'Actualizar Proveedor']);
        $deleteProvider = Permission::create(['name' => 'delete provider', 'display_name' => 'Eliminar Proveedor']);
        // Ventas
        $createSale = Permission::create(['name' => 'create sale', 'display_name' => 'Crear Venta']);
        $viewSale = Permission::create(['name' => 'view sale','display_name' => 'Ver Venta']);
        $detailSale = Permission::create(['name' => 'detail sale','display_name' => 'Detalle Venta']);
        $updateSale = Permission::create(['name' => 'update sale', 'display_name' => 'Actualizar Venta']);
        $deleteSale = Permission::create(['name' => 'delete sale', 'display_name' => 'Eliminar Venta']);
        // Clientes
        $createCustomer = Permission::create(['name' => 'create customer', 'display_name' => 'Crear Cliente']);
        $viewCustomer = Permission::create(['name' => 'view customer','display_name' => 'Ver Cliente']);
        $detailCustomer = Permission::create(['name' => 'detail customer','display_name' => 'Detalle Cliente']);
        $updateCustomer = Permission::create(['name' => 'update customer', 'display_name' => 'Actualizar Cliente']);
        $deleteCustomer = Permission::create(['name' => 'delete customer', 'display_name' => 'Eliminar Cliente']);
        // $adminRole = User::find(2);
        // $adminRole->givePermissionsTo($viewDivisa);
         
    }
}
