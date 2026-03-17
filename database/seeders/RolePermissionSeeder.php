<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'ver_dashboard',

            'ver_clientes',
            'crear_clientes',
            'editar_clientes',

            'ver_productos',
            'crear_productos',
            'editar_productos',

            'ver_almacenes',
            'crear_almacenes',
            'editar_almacenes',

            'ver_usuarios',
            'crear_usuarios',
            'editar_usuarios',
            'asignar_roles',

            'ver_existencias',
            'ver_movimientos',
            'crear_ajustes',
            'crear_traspasos',
            'aplicar_traspasos',

            'ver_remisiones_privado',
            'crear_remisiones_privado',
            'editar_remisiones_privado',
            'confirmar_remisiones_privado',
            'cancelar_remisiones_privado',
            'imprimir_remisiones_privado',

            'ver_servicios_integrales',
            'crear_servicios_integrales',
            'editar_servicios_integrales',
            'cargar_materiales_integral',
            'cerrar_servicios_integrales',
            'cancelar_servicios_integrales',
            'imprimir_servicios_integrales',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        $ventas = Role::firstOrCreate(['name' => 'ventas_privado', 'guard_name' => 'web']);
        $integral = Role::firstOrCreate(['name' => 'tecnico_integral', 'guard_name' => 'web']);
        $almacen = Role::firstOrCreate(['name' => 'almacen', 'guard_name' => 'web']);

        $admin->givePermissionTo(Permission::all());

        $ventas->givePermissionTo([
            'ver_dashboard',
            'ver_clientes',
            'ver_productos',
            'ver_almacenes',
            'ver_existencias',
            'ver_remisiones_privado',
            'crear_remisiones_privado',
            'editar_remisiones_privado',
            'confirmar_remisiones_privado',
            'cancelar_remisiones_privado',
            'imprimir_remisiones_privado',
        ]);

        $integral->givePermissionTo([
            'ver_dashboard',
            'ver_clientes',
            'ver_productos',
            'ver_almacenes',
            'ver_existencias',
            'ver_servicios_integrales',
            'crear_servicios_integrales',
            'editar_servicios_integrales',
            'cargar_materiales_integral',
            'cerrar_servicios_integrales',
            'cancelar_servicios_integrales',
            'imprimir_servicios_integrales',
        ]);

        $almacen->givePermissionTo([
            'ver_dashboard',
            'ver_productos',
            'ver_almacenes',
            'ver_existencias',
            'ver_movimientos',
            'crear_ajustes',
            'crear_traspasos',
            'aplicar_traspasos',
        ]);
    }
}