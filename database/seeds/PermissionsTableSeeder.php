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
        $viewDashboard = Permission::create(['menu_id' => 1, 'name' => 'view dashboard','display_name' => 'Ver Dashboard', 'option' => 'menu']);
        $viewDivisa = Permission::create(['menu_id' => 2, 'name' => 'view divisa','display_name' => 'Ver Cotización', 'option' => 'menu']);
        $createDivisa = Permission::create(['menu_id' => 2, 'name' => 'create divisa', 'display_name' => 'Crear Cotización', 'option' => 'create']);
        $detailDivisa = Permission::create(['menu_id' => 2, 'name' => 'detail divisa','display_name' => 'Detalle Cotización', 'option' => 'show']);
        $updateDivisa = Permission::create(['menu_id' => 2, 'name' => 'update divisa', 'display_name' => 'Actualizar Cotización', 'option' => 'update']);
        $deleteDivisa = Permission::create(['menu_id' => 2, 'name' => 'delete divisa', 'display_name' => 'Eliminar Cotización', 'option' => 'delete']);
        // Categorías
        $createCategory = Permission::create(['menu_id' => 3,'name' => 'view storage', 'display_name' => 'Menú Almacén', 'option' => 'menu']);
        $viewCategory = Permission::create(['menu_id' => 4,'name' => 'view category','display_name' => 'Ver Categoría','option' => 'menu']);
        $createCategory = Permission::create(['menu_id' => 4,'name' => 'create category', 'display_name' => 'Crear Categoría', 'option' => 'create']);
        $detailCategory = Permission::create(['menu_id' => 4,'name' => 'detail category','display_name' => 'Detalle Categoría','option' => 'show']);
        $updateCategory = Permission::create(['menu_id' => 4,'name' => 'update category', 'display_name' => 'Actualizar Categoría','option' => 'update']);
        $deleteCategory = Permission::create(['menu_id' => 4,'name' => 'delete category', 'display_name' => 'Eliminar Categoría','option' => 'delete']);
        // Productos
        $viewProduct = Permission::create(['menu_id' => 5,'name' => 'view product','display_name' => 'Ver Producto','option' => 'menu']);
        $createProduct = Permission::create(['menu_id' => 5,'name' => 'create product', 'display_name' => 'Crear Producto','option' => 'create']);
        $detailProduct = Permission::create(['menu_id' => 5,'name' => 'detail product','display_name' => 'Detalle Producto','option' => 'show']);
        $updateProduct = Permission::create(['menu_id' => 5,'name' => 'update product', 'display_name' => 'Actualizar Producto','option' => 'update']);
        $deleteProduct = Permission::create(['menu_id' => 5,'name' => 'delete product', 'display_name' => 'Eliminar Producto','option' => 'delete']);
        // Lista de Productos
        $viewListProduct = Permission::create(['menu_id' => 6,'name' => 'view list','display_name' => 'Ver list','option' => 'menu']);
        $createListProduct = Permission::create(['menu_id' => 6,'name' => 'create list', 'display_name' => 'Crear list','option' => 'create']);
        $detailListProduct = Permission::create(['menu_id' => 6,'name' => 'detail list','display_name' => 'Detalle list','option' => 'show']);
        $updateListProduct = Permission::create(['menu_id' => 6,'name' => 'update list', 'display_name' => 'Actualizar list','option' => 'update']);
        $deleteListProduct = Permission::create(['menu_id' => 6,'name' => 'delete list', 'display_name' => 'Eliminar list','option' => 'delete']);
        // Ingresos
        $viewIncome = Permission::create(['menu_id' => 7,'name' => 'view shoppin','display_name' => 'Ver Ingreso','option' => 'menu']);
        $viewIncome = Permission::create(['menu_id' => 8,'name' => 'view income','display_name' => 'Ver Ingreso','option' => 'menu']);
        $createIncome = Permission::create(['menu_id' => 8,'name' => 'create income', 'display_name' => 'Crear Ingreso','option' => 'create']);
        $detailIncome = Permission::create(['menu_id' => 8,'name' => 'detail income','display_name' => 'detail Ingreso','option' => 'show']);
        $updateIncome = Permission::create(['menu_id' => 8,'name' => 'update income', 'display_name' => 'Actualizar Ingreso','option' => 'update']);
        $deleteIncome = Permission::create(['menu_id' => 8,'name' => 'delete income', 'display_name' => 'Eliminar Ingreso','option' => 'delete']);
        // Proveeedores
        $viewProvider = Permission::create(['menu_id' => 9,'name' => 'view provider','display_name' => 'Ver Proveedor','option' => 'menu']);
        $createProvider = Permission::create(['menu_id' => 9,'name' => 'create provider', 'display_name' => 'Crear Proveedor','option' => 'create']);
        $detailProvider = Permission::create(['menu_id' => 9,'name' => 'detail provider','display_name' => 'Detalle Proveedor','option' => 'show']);
        $updateProvider = Permission::create(['menu_id' => 9,'name' => 'update provider', 'display_name' => 'Actualizar Proveedor','option' => 'update']);
        $deleteProvider = Permission::create(['menu_id' => 9,'name' => 'delete provider', 'display_name' => 'Eliminar Proveedor','option' => 'delete']);
        // Ven,'option' => 'delettas
        $viewSale = Permission::create(['menu_id' => 10,'name' => 'view sales','display_name' => 'Menú Venta','option' => 'menu']);
        $viewSale = Permission::create(['menu_id' => 10,'name' => 'view sale','display_name' => 'Ver Venta','option' => 'menu']);
        $createSale = Permission::create(['menu_id' => 10,'name' => 'create sale', 'display_name' => 'Crear Venta','option' => 'create']);
        $detailSale = Permission::create(['menu_id' => 10,'name' => 'detail sale','display_name' => 'Detalle Venta','option' => 'show']);
        $updateSale = Permission::create(['menu_id' => 10,'name' => 'update sale', 'display_name' => 'Actualizar Venta','option' => 'update']);
        $deleteSale = Permission::create(['menu_id' => 10,'name' => 'delete sale', 'display_name' => 'Eliminar Venta','option' => 'delete']);
        // Clientes
        $viewCustomer = Permission::create(['menu_id' => 12,'name' => 'view customer','display_name' => 'Ver Cliente','option' => 'menu']);
        $createCustomer = Permission::create(['menu_id' => 12,'name' => 'create customer', 'display_name' => 'Crear Cliente','option' => 'create']);
        $detailCustomer = Permission::create(['menu_id' => 12,'name' => 'detail customer','display_name' => 'Detalle Cliente','option' => 'show']);
        $updateCustomer = Permission::create(['menu_id' => 12,'name' => 'update customer', 'display_name' => 'Actualizar Cliente','option' => 'update']);
        $deleteCustomer = Permission::create(['menu_id' => 12,'name' => 'delete customer', 'display_name' => 'Eliminar Cliente','option' => 'delete']);
        // $adminRole = User::find(2);
        // $adminRole->givePermissionsTo($viewDivisa);
         
    }
}
