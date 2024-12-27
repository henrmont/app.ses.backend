<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            DB::beginTransaction();

            $permissions = [
                'super admin',
                'user'
            ];

            foreach($permissions as $vlr) {
                $permission = Permission::create([
                    'name'  => $vlr,
                    'guard_name' => 'api',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }

    }
}
