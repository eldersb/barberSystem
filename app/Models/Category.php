<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price"
    ];

    protected $table = "categories";

    public function schedullings()
    {
        return $this->belongsToMany(Schedulling::class, 'category_schedulling')
                    ->withPivot('price'); // Inclui o preço na tabela intermediária
    }

}
