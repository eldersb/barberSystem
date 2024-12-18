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
        "address",
        "cep",
        "birthDate"
    ];

    protected $table = "clients";

    public function schedullings()
    {
        return $this->hasMany(Schedulling::class, 'client_id');
    }
}
