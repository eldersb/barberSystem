<?php

namespace App\Models;

use Dotenv\Exception\ValidationException;
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

    public static function existsForBarberAtSameTime($barberId, $serviceTime)
    {
        return self::where('barber_id', $barberId)
            ->where('serviceTime', $serviceTime)
            ->exists();
    }

    public static function existsForClientAtSameTime($clientId, $serviceTime)
    {
        return self::where('client_id', $clientId)
            ->where('serviceTime', $serviceTime)
            ->exists();
    }

    public static function createService(array $data)
    {
        $barberId = $data['barber_id'];
        $clientId = $data['client_id'];
        $serviceTime = $data['serviceTime'];

        if (self::existsForBarberAtSameTime($barberId, $serviceTime)) {
            throw new ValidationException('Este barbeiro já tem um agendamento nesse horário.');
        }

        if (self::existsForClientAtSameTime($clientId, $serviceTime)) {
            throw new ValidationException('Este cliente já tem um agendamento nesse horário.');
        }

        return self::create($data);
    }

    public function updateSchedullingWithCategories($data, $categories)
    {
        $this->update($data);

        $categories = Category::whereIn('id', $categories)->get();

        $totalValue = $categories->sum('price');

        $this->serviceValue = $totalValue;
        $this->save();

        $pivotData = [];
        foreach ($categories as $category) {
            $pivotData[$category->id] = ['price' => $category->price];
        }

        $this->categories()->sync($pivotData);

        return $this;
    }

    public function CalculateTotalService(array $categoryIds)
    {
        $categories = Category::whereIn('id', $categoryIds)->get();
        
        $totalValue = $categories->sum('price');
        
        foreach ($categories as $category) {
            $this->categories()->attach($category->id, ['price' => $category->price]);
        }

        $this->serviceValue = $totalValue;
        $this->save();
    }
}
