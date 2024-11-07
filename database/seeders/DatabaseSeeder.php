<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route as FacadesRoute;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $role1 = Role::factory()->create(['name' => 'category']);
        $role2 = Role::factory()->create(['name' => 'post']);
        $role3 = Role::factory()->create(['name' => 'student']);
        $role4 = Role::factory()->create(['name' => 'company']);
        $role5 = Role::factory()->create(['name' => 'admin']);

        for ($i=1; $i <=10 ; $i++) { 
            $user = User::create([
                'name'=> 'User'. $i,
                'email'=> 'email'. $i . '@gmail.com',
                'password'=> Hash::make('qwerty'),
            ]);
            
            $row = rand(1,5);
            
            for($k=0;$k<$row;$k++){
                $user->roles()->attach(rand(1,5));
            }
        }

        $routes = FacadesRoute::getRoutes();
        
        foreach ($routes as $route){
            $key = $route->getName();
            if ($key && !str_starts_with($key,'generated::') && $key !== 'storage.local') {
                $name = ucfirst(str_replace('.','-',$key));

                Permission::create([
                    'key'=>$key,
                    'name'=>$name
                ]);
            } 
        }

        $permissions = Permission::pluck('id')->toArray();

        $role1->permissions()->attach($permissions);
        $role2->permissions()->attach($permissions);
        $role3->permissions()->attach($permissions);
        $role4->permissions()->attach($permissions);
        $role5->permissions()->attach($permissions);

        // $this->call([
        //     PostSeeder::class,
        //     StudentSeeder::class,
        //     CategorySeeder::class,
        //     CompanySeeder::class
        // ]);
    }
}
