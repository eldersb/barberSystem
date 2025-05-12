<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ClientService
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAll()
    {
        return Cache::remember('clients', 3600, function () {  
            return ClientResource::collection($this->client->all());    
         });    
    }

    public function searchByNameOrCpf(string $keyword)
    {
        $clients = Client::where(function($query) use ($keyword) {
             $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$keyword}%")
              ->orWhere('first_name', 'LIKE', "%{$keyword}%")
              ->orWhere('last_name', 'LIKE', "%{$keyword}%")
              ->orWhere('document', 'LIKE', "%{$keyword}%");
        })->get();
        
        return ClientResource::collection($clients);
    }

    public function create(array $data)
    {
        $client = $this->client->create($data);

         Cache::forget('clients');

         Cache::put('clients', ClientResource::collection($this->client->all()), 3600);

         return $client;

    }

    public function getById(string $id)
    {
        return $this->client->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $client = $this->getById($id);
       
        $client->update($data);

        return $client;
    }

    public function delete(string $id): void
    {
        $client = Client::findOrFail($id);
        $client->delete();
    }
}
