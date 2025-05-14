<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
       $this->createDefaultUser();
       User::factory(10)->create();
    }
    
    public function createDefaultUser() : void
    {
         $user = User::firstOrNew(['email' => 'admin@admin.com']);

        if (!$user->exists) { // Se o usuário já foi cadastrado uma vez, não será de novo
            $user->name = 'Administrador';
            $user->password = Hash::make('admin123');
            $user->role = 'developer';
            $user->save();
        } 
    }


}
