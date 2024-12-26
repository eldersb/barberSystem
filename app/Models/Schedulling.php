<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scopeForDay($query, $date)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();

        return $query->whereBetween('serviceTime', [$startDate, $endDate]);
    }

    public static function validateServiceTime($barberId, $clientId, $serviceTime)
    {
        $timezone = 'America/Sao_Paulo';

        $serviceTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $serviceTime, $timezone);
        
        $startOfDay = Carbon::createFromTime(9, 0, 0, $timezone);   // 09:00
        $endOfDay = Carbon::createFromTime(20, 0, 0, $timezone);    // 20:00

        if ($serviceTimeCarbon->lt($startOfDay) || $serviceTimeCarbon->gt($endOfDay)) {
            throw new ValidationException('O horário do agendamento deve estar entre 09:00 e 20:00.');
        }

        $now = Carbon::now($timezone)->copy()->setSeconds(0)->setMilliseconds(0);

        if ($serviceTimeCarbon->lt($now)) {
            throw new ValidationException('O agendamento não pode ser feito para um horário anterior ao horário atual.');
        }


        if (self::existsForBarberAtSameTime($barberId, $serviceTime)) {
            throw new ValidationException('Este barbeiro já tem um agendamento nesse horário.');
        }

        if (self::existsForClientAtSameTime($clientId, $serviceTime)) {
            throw new ValidationException('Este cliente já tem um agendamento nesse horário.');
        }
    }


    public static function createService(array $data)
    {
        $barberId = $data['barber_id'];
        $clientId = $data['client_id'];
        $serviceTime = $data['serviceTime'];

        self::validateServiceTime($barberId, $clientId, $serviceTime);

        return self::create($data);
    }
    
    public function updateSchedullingWithCategories($data, $categories)
    {
            
        $barberId = $data['barber_id'];  
        $clientId = $data['client_id'];  
        $serviceTime = $data['serviceTime'];  

        self::validateServiceTime($barberId, $clientId, $serviceTime); 

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


    public function finalizeScheduling(array $data)
    {
        // Atualizar o status para "Finalizado"
        $this->status = 'Finalizado';

        // Campos permitidos para atualização
        $fieldsToUpdate = ['barber_id', 'payment'];

        // Atualizar os campos fornecidos no array $data
        foreach ($fieldsToUpdate as $field) {
            if (isset($data[$field])) {
                $this->$field = $data[$field];
            }
        }

        // Se categorias foram fornecidas, calcular o total do serviço
        if (isset($data['categories'])) {
            $this->CalculateTotalService($data['categories']);
        }

        // Salvar o agendamento
        $this->save();
    }

}
