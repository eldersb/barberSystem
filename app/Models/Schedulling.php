<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedulling extends Model
{
    use HasFactory;

    protected $fillable = [
        "barber_id", 
        "client_id", 
        "category_id",
        "serviceTime",
        "serviceValue",
        "status" 
    ];

    protected $table = "schedullings";
}
