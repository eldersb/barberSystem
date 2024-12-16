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
        "payment",
        "status" 
    ];

    protected $table = "schedullings";

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_schedulling')
            ->withPivot('price'); 
    }


    public function associateCategoriesAndCalculateTotal(array $categoryIds)
    {
        $categories = Category::whereIn('id', $categoryIds)->get();
        
        // Calcula o valor total somando os preços das categorias
        $totalValue = $categories->sum('price');
        
        // Associa as categorias ao agendamento
        foreach ($categories as $category) {
            $this->categories()->attach($category->id, ['price' => $category->price]);
        }

        // Atualiza o valor total no agendamento
        $this->serviceValue = $totalValue;
        $this->save();
    }
}
