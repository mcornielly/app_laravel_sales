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

        $menu1 = new Menu;
        $menu1->name = "Dashboard";
        $menu1->order = 1;
        $menu1->hierarchy = 0;
        $menu1->icon = '<i class="nav-icon fas fa-tachometer-alt">&nbsp;</i>';
        $menu1->save();

        $menu2 = new Menu;
        $menu2->name = "Divisa";
        $menu2->order = 2;
        $menu2->hierarchy = 0;
        $menu2->icon = '<i class="nav-icon fas fa-money-bill-alt">&nbsp;</i>';
        $menu2->save();

        $menu3 = new Menu;
        $menu3->name = "Almacén";
        $menu3->order = 3;
        $menu3->hierarchy = 0;
        $menu3->icon = '<i class="nav-icon fas fa-boxes">&nbsp;</i>';
        $menu3->save();

        $submenu1 = new Menu;
        $submenu1->name = "Categoría";
        $submenu1->order = 1;
        $submenu1->hierarchy = 3;
        $submenu1->icon = '<i class="nav-icon fas fa-tags">&nbsp;</i>';
        $submenu1->save();

        $submenu2 = new Menu;
        $submenu2->name = "Producto";
        $submenu2->order = 2;
        $submenu2->hierarchy = 3;
        $submenu2->icon = '<i class="nav-icon fas fa-box">&nbsp;</i>';
        $submenu2->save();

        $submenu3 = new Menu;
        $submenu3->name = "Lista de Percios";
        $submenu3->order = 3;
        $submenu3->hierarchy = 3;
        $submenu3->icon = '<i class="nav-icon fas fa-list-alt">&nbsp;</i>';
        $submenu3->save();

        $menu4 = new Menu;
        $menu4->name = "Compra";
        $menu4->order = 4;
        $menu4->icon = '<i class="nav-icon fas fa-store">&nbsp;</i>';
        $menu4->save();

        $submenu4 = new Menu;
        $submenu4->name = "Ingresos";
        $submenu4->order = 1;
        $submenu4->hierarchy = 7;
        $submenu4->icon = '<i class="nav-icon fas fa-piggy-bank">&nbsp;</i>';
        $submenu4->save();

        $submenu5 = new Menu;
        $submenu5->name = "Proveedores";
        $submenu5->order = 2;
        $submenu5->hierarchy = 7;
        $submenu5->icon = '<i class="nav-icon fas fa-industry">&nbsp;</i>';
        $submenu5->save();

        $menu5 = new Menu;
        $menu5->name = "Ventas";
        $menu5->order = 5;
        $menu5->icon = '<i class="nav-icon fas fa-handshake">&nbsp;</i>';
        $menu5->save();

        $submenu6 = new Menu;
        $submenu6->name = "Ventas";
        $submenu6->order = 1;
        $submenu6->hierarchy = 10;
        $submenu6->icon = '<i class="nav-icon fas fa-cash-register">&nbsp;</i>';
        $submenu6->save();

        $submenu7 = new Menu;
        $submenu7->name = "Clientes";
        $submenu7->order = 2;
        $submenu7->hierarchy = 10;
        $submenu7->icon = '<i class="nav-icon fas fa-user-tie">&nbsp;</i>';
        $submenu7->save();

        $menu6 = new Menu;
        $menu6->name = "Reportes";
        $menu6->order = 6;
        $menu6->icon = '<i class="nav-icon fas fa-clipboard">&nbsp;</i>';
        $menu6->save();

        $submenu8 = new Menu;
        $submenu8->name = "Reportes Ingresos";
        $submenu8->order = 1;
        $submenu8->hierarchy = 13;
        $submenu8->icon = '<i class="nav-icon fas fa-file-invoice">&nbsp;</i>';
        $submenu8->save();

        $submenu9 = new Menu;
        $submenu9->name = "Reportes Ventas";
        $submenu9->order = 2;
        $submenu9->hierarchy = 13;
        $submenu9->icon = '<i class="nav-icon fas fa-file-invoice-dollar">&nbsp;</i>';
        $submenu9->save();

        $menu7 = new Menu;
        $menu7->name = "Accesos";
        $menu7->order = 7;
        $menu7->hierarchy = 0;
        $menu7->icon = '<i class="nav-icon fas fa-door-open">&nbsp;</i>';
        $menu7->save();

        $submenu10 = new Menu;
        $submenu10->name = "Usuarios";
        $submenu10->order = 1;
        $submenu10->hierarchy = 16;
        $submenu10->icon = '<i class="nav-icon fas fa-users">&nbsp;</i>';
        $submenu10->save();

        $submenu11 = new Menu;
        $submenu11->name = "Roles";
        $submenu11->order = 2;
        $submenu11->hierarchy = 16;
        $submenu11->icon = '<i class="nav-icon fas fa-users-cog">&nbsp;</i>';
        $submenu11->save();

    }
}
