<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientService
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAll()
    {
        return ClientResource::collection($this->client->all());        
    }

    public function searchByNameOrCpf(string $keyword)
    {
        $clients = Client::where(function($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('cpf', 'LIKE', "%{$keyword}%");
        })->get();
    
        
        return ClientResource::collection($clients);
    }

    public function create(array $data)
    {
        return $this->client->create($data);
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
