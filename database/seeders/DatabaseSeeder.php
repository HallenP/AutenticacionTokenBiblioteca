<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call([
            UserSeeder::class
            ]);
            
            User::create([
                'name' => 'hallen',
                'lastname' => 'lluglla',
                'cedula' => '1750043813',
                'edad' => '22',
                'email' => 'hp@gmail.com',
                'password' => Hash::make('123'),
                'IdRol' => '1'
            ]);
            Rol::create([
                
                'Descripcion' => 'Administrador'
            ]);
            Rol::create([
                'Descripcion' => 'Lector'
            ]);
    }
}
