<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scheduling;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "gender",
        "birthDate",
        "document",
        "telephone",
        "email",
        "street_name",
        "street_number",
        "neighborhood",
        "city",
        "state",
        "cep"
    ];

    protected $table = "clients";

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class, 'client_id');
    }
}
