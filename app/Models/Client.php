<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "telephone",
        "cpf",
        "email",
        "address",
        "cep",
        "birthDate"
    ];

    protected $table = "clients";

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class, 'client_id');
    }
}
