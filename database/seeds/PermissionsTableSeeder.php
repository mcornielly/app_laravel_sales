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

        // $adminRole = User::find(2);
        // $adminRole->givePermissionsTo($viewDivisa);
         
    }
}
