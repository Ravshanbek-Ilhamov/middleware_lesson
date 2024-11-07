<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        Role::factory()->create(['name' => 'category']);
        Role::factory()->create(['name' => 'post']);
        Role::factory()->create(['name' => 'student']);
        Role::factory()->create(['name' => 'company']);
        Role::factory()->create(['name' => 'admin']);

        for ($i=1; $i <=10 ; $i++) { 
            $user = User::create([
                'name'=> 'User'. $i,
                'email'=> 'email'. $i . '@gmail.com',
                'password'=> Hash::make('qwerty'),
            ]);
            
            $row = rand(1,3);
            
            for($k=0;$k<$row;$k++){
                $user->roles()->attach(rand(1,3));
            }
            
        }
        $this->call([
            PostSeeder::class,
            StudentSeeder::class,
            CategorySeeder::class,
            CompanySeeder::class
        ]);
    }
}
