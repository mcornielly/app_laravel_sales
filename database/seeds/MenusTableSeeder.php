<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::truncate();

        Menu::create([
            'name' => 'Dashboard', 
            'order' => 1,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Almacen', 
            'order' => 2,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Categoría', 
            'order' => 1,
            'hierarchy' => 1
        ]);
        
        Menu::create([
            'name' => 'Productos', 
            'order' => 2,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Lista de Precios', 
            'order' => 2,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Compras', 
            'order' => 4,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Ingresos', 
            'order' => 1,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Proveedores', 
            'order' => 2,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Ventas', 
            'order' => 5,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Ventas', 
            'order' => 1,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Clientes', 
            'order' => 2,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Reportes', 
            'order' => 6,
            'hierarchy' => 0
        ]);

        
        Menu::create([
            'name' => 'Reportes Ingresos', 
            'order' => 1,
            'hierarchy' => 1
        ]);

        
        Menu::create([
            'name' => 'Reportes ventas', 
            'order' => 2,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Accesos', 
            'order' => 7,
            'hierarchy' => 0
        ]);

        Menu::create([
            'name' => 'Usuarios', 
            'order' => 1,
            'hierarchy' => 1
        ]);

        Menu::create([
            'name' => 'Roles', 
            'order' => 2,
            'hierarchy' => 1
        ]);

    }
}
