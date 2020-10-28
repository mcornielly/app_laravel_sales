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
        $viewDivisa = Permission::create(['menu_id' => 2, 'name' => 'view divisa','display_name' => 'Ver Cotizaciones', 'option' => 'menu']);
        $createDivisa = Permission::create(['menu_id' => 2, 'name' => 'create divisa', 'display_name' => 'Crear Cotización', 'option' => 'create']);
        $detailDivisa = Permission::create(['menu_id' => 2, 'name' => 'detail divisa','display_name' => 'Detalle Cotización', 'option' => 'show']);
        $updateDivisa = Permission::create(['menu_id' => 2, 'name' => 'update divisa', 'display_name' => 'Actualizar Cotización', 'option' => 'update']);
        $deleteDivisa = Permission::create(['menu_id' => 2, 'name' => 'delete divisa', 'display_name' => 'Eliminar Cotización', 'option' => 'delete']);
        // Categorías
        $viewCategories = Permission::create(['menu_id' => 3,'name' => 'view storage', 'display_name' => 'Menú Almacén', 'option' => 'menu']);
        $viewCategory = Permission::create(['menu_id' => 4,'name' => 'view category','display_name' => 'Ver Categorías','option' => 'sub-menu']);
        $createCategory = Permission::create(['menu_id' => 4,'name' => 'create category', 'display_name' => 'Crear Categoría', 'option' => 'create']);
        $detailCategory = Permission::create(['menu_id' => 4,'name' => 'detail category','display_name' => 'Detalle Categoría','option' => 'show']);
        $updateCategory = Permission::create(['menu_id' => 4,'name' => 'update category', 'display_name' => 'Actualizar Categoría','option' => 'update']);
        $deleteCategory = Permission::create(['menu_id' => 4,'name' => 'delete category', 'display_name' => 'Eliminar Categoría','option' => 'delete']);
        // Productos
        $viewProduct = Permission::create(['menu_id' => 5,'name' => 'view product','display_name' => 'Ver Productos','option' => 'sub-menu']);
        $createProduct = Permission::create(['menu_id' => 5,'name' => 'create product', 'display_name' => 'Crear Producto','option' => 'create']);
        $detailProduct = Permission::create(['menu_id' => 5,'name' => 'detail product','display_name' => 'Detalle Producto','option' => 'show']);
        $updateProduct = Permission::create(['menu_id' => 5,'name' => 'update product', 'display_name' => 'Actualizar Producto','option' => 'update']);
        $deleteProduct = Permission::create(['menu_id' => 5,'name' => 'delete product', 'display_name' => 'Eliminar Producto','option' => 'delete']);
        // Lista de Productos
        $viewListProduct = Permission::create(['menu_id' => 6,'name' => 'view list','display_name' => 'Ver lista','option' => 'sub-menu']);
        $createListProduct = Permission::create(['menu_id' => 6,'name' => 'create list', 'display_name' => 'Crear lista','option' => 'create']);
        $detailListProduct = Permission::create(['menu_id' => 6,'name' => 'detail list','display_name' => 'Detalle lista','option' => 'show']);
        $updateListProduct = Permission::create(['menu_id' => 6,'name' => 'update list', 'display_name' => 'Actualizar lista','option' => 'update']);
        $deleteListProduct = Permission::create(['menu_id' => 6,'name' => 'delete list', 'display_name' => 'Eliminar lista','option' => 'delete']);
        // Ingresos
        $viewShopping = Permission::create(['menu_id' => 7,'name' => 'view shopping','display_name' => 'Menú Compras','option' => 'menu']);
        $viewIncome = Permission::create(['menu_id' => 8,'name' => 'view income','display_name' => 'Ver Ingresos','option' => 'sub-menu']);
        $createIncome = Permission::create(['menu_id' => 8,'name' => 'create income', 'display_name' => 'Crear Ingreso','option' => 'create']);
        $detailIncome = Permission::create(['menu_id' => 8,'name' => 'detail income','display_name' => 'detail Ingreso','option' => 'show']);
        $updateIncome = Permission::create(['menu_id' => 8,'name' => 'update income', 'display_name' => 'Actualizar Ingreso','option' => 'update']);
        $deleteIncome = Permission::create(['menu_id' => 8,'name' => 'delete income', 'display_name' => 'Eliminar Ingreso','option' => 'delete']);
        // Proveeedores
        $viewProvider = Permission::create(['menu_id' => 9,'name' => 'view provider','display_name' => 'Ver Proveedores','option' => 'sub-menu']);
        $createProvider = Permission::create(['menu_id' => 9,'name' => 'create provider', 'display_name' => 'Crear Proveedor','option' => 'create']);
        $detailProvider = Permission::create(['menu_id' => 9,'name' => 'detail provider','display_name' => 'Detalle Proveedor','option' => 'show']);
        $updateProvider = Permission::create(['menu_id' => 9,'name' => 'update provider', 'display_name' => 'Actualizar Proveedor','option' => 'update']);
        $deleteProvider = Permission::create(['menu_id' => 9,'name' => 'delete provider', 'display_name' => 'Eliminar Proveedor','option' => 'delete']);
        // Ventas
        $viewSales = Permission::create(['menu_id' => 10,'name' => 'view sales','display_name' => 'Menú Ventas','option' => 'menu']);
        $viewSale = Permission::create(['menu_id' => 11,'name' => 'view sale','display_name' => 'Ver Ventas','option' => 'sub-menu']);
        $createSale = Permission::create(['menu_id' => 11,'name' => 'create sale', 'display_name' => 'Crear Venta','option' => 'create']);
        $detailSale = Permission::create(['menu_id' => 11,'name' => 'detail sale','display_name' => 'Detalle Venta','option' => 'show']);
        $updateSale = Permission::create(['menu_id' => 11,'name' => 'update sale', 'display_name' => 'Actualizar Venta','option' => 'update']);
        $deleteSale = Permission::create(['menu_id' => 11,'name' => 'delete sale', 'display_name' => 'Eliminar Venta','option' => 'delete']);
        // Clientes
        $viewCustomer = Permission::create(['menu_id' => 12,'name' => 'view customer','display_name' => 'Ver Clientes','option' => 'sub-menu']);
        $createCustomer = Permission::create(['menu_id' => 12,'name' => 'create customer', 'display_name' => 'Crear Cliente','option' => 'create']);
        $detailCustomer = Permission::create(['menu_id' => 12,'name' => 'detail customer','display_name' => 'Detalle Cliente','option' => 'show']);
        $updateCustomer = Permission::create(['menu_id' => 12,'name' => 'update customer', 'display_name' => 'Actualizar Cliente','option' => 'update']);
        $deleteCustomer = Permission::create(['menu_id' => 12,'name' => 'delete customer', 'display_name' => 'Eliminar Cliente','option' => 'delete']);
        // Reportes
        $viewReport = Permission::create(['menu_id' => 13,'name' => 'view reports','display_name' => 'Menú Reportes','option' => 'menu']);
        $viewIncomeReport = Permission::create(['menu_id' => 14,'name' => 'view income report','display_name' => 'Ver Reportes Ingresos','option' => 'sub-menu']);
        $detailIncomeReport = Permission::create(['menu_id' => 14,'name' => 'detail income report','display_name' => 'Detalle Reporte Ingresos','option' => 'show']);
        $viewSaleReport = Permission::create(['menu_id' => 15,'name' => 'view sale report','display_name' => 'Ver Reportes Ventas','option' => 'sub-menu']);
        $detailSaleReport = Permission::create(['menu_id' => 15,'name' => 'detail sale report','display_name' => 'Detalle Reporte Ventas','option' => 'show']);
        // Accesos Usuarios - Roles
        $viewAccess = Permission::create(['menu_id' => 16,'name' => 'view access','display_name' => 'Menú Accesos','option' => 'menu']);
        $viewUser = Permission::create(['menu_id' => 17,'name' => 'view user','display_name' => 'Ver Usuarios','option' => 'sub-menu']);
        $createUser = Permission::create(['menu_id' => 17,'name' => 'create user', 'display_name' => 'Crear Usuario','option' => 'create']);
        $detailUser = Permission::create(['menu_id' => 17,'name' => 'detail user','display_name' => 'Detalle Usuario','option' => 'show']);
        $updateUser = Permission::create(['menu_id' => 17,'name' => 'update user', 'display_name' => 'Actualizar Usuario','option' => 'update']);
        $deleteUser = Permission::create(['menu_id' => 17,'name' => 'delete user', 'display_name' => 'Eliminar Usuario','option' => 'delete']);
        // Clientes
        $viewRole = Permission::create(['menu_id' => 18,'name' => 'view role','display_name' => 'Ver Roles','option' => 'sub-menu']);
        $createRole = Permission::create(['menu_id' => 18,'name' => 'create role', 'display_name' => 'Crear Rol','option' => 'create']);
        $detailRole = Permission::create(['menu_id' => 18,'name' => 'detail role','display_name' => 'Detalle Rol','option' => 'show']);
        $updateRole = Permission::create(['menu_id' => 18,'name' => 'update role', 'display_name' => 'Actualizar Rol','option' => 'update']);
        $deleteRole = Permission::create(['menu_id' => 18,'name' => 'delete role', 'display_name' => 'Eliminar Rol','option' => 'delete']);
        
        // $adminRole = User::find(2);
        // $adminRole->givePermissionsTo($viewDivisa);
         
    }
}
