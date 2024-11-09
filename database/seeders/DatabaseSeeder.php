<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route as FacadesRoute;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $role1 = Role::factory()->create(['name' => 'category']);
        $role2 = Role::factory()->create(['name' => 'post']);
        $role3 = Role::factory()->create(['name' => 'student']);
        $role4 = Role::factory()->create(['name' => 'company']);
        $role5 = Role::factory()->create(['name' => 'admin']);

        $roles = [$role1->id, $role2->id, $role3->id, $role4->id, $role5->id];

        // Create users and assign each one a single role
        for ($i = 1; $i <= 10; $i++) { 
            $user = User::create([
                'name' => 'User' . $i,
                'email' => 'email' . $i . '@gmail.com',
                'password' => Hash::make('qwerty'),
            ]);

            // Assign a single random role to the user
            $user->roles()->attach($roles[array_rand($roles)]);
        }

        // Assign permissions to roles based on routes
        $routes = FacadesRoute::getRoutes();

        foreach ($routes as $route) {
            $key = $route->getName();
            if ($key && !str_starts_with($key, 'generated::') && $key !== 'storage.local') {
                $name = ucfirst(str_replace('.', '-', $key));

                Permission::create([
                    'key' => $key,
                    'name' => $name,
                ]);
            }
        }

        // Attach all permissions to each role
        $permissions = Permission::pluck('id')->toArray();
        foreach ($roles as $roleId) {
            Role::find($roleId)->permissions()->attach($permissions);
        }

        // Uncomment if additional seeders are needed
        // $this->call([
        //     PostSeeder::class,
        //     StudentSeeder::class,
        //     CategorySeeder::class,
        //     CompanySeeder::class,
        // ]);
    }
}
