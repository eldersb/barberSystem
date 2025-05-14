<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserService
{

   protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return Cache::remember('users', 3600, function () {  
            return UserResource::collection($this->user->all());    
         }); 
    }

    public function getById(string $id)
    {
        return $this->user->findOrFail($id);
    }

    public function registerUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }

     public function update(string $id, array $data)
    {
        $user = $this->getById($id);
       
        $user->update($data);

        Cache::forget('users');

        Cache::put('users', UserResource::collection($this->user->all()), 3600);

        return $user;
    }

     public function delete(string $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

}
