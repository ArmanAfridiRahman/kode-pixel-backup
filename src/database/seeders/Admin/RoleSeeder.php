<?php

namespace Database\Seeders\Admin;

use App\Enums\StatusEnum;
use App\Models\Admin\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        if(Role::count() == 0){
            Role::create([
               'name' => 'Manager', 
               'created_by' => 1, 
               'status' => StatusEnum::true->status(), 
               'permissions' => json_encode(config('settings')['role_permissions'])
            ]);
        }
    }
}
