<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "telephone",
        "cpf",
        "status"
    ];

    protected $table = "barbers";

    const HORARIO_INICIO = '09:00';
    const HORARIO_FIM = '20:00';

    public function isDisponivel(Carbon $dataHora)
    {
        // Verificando se o horário está dentro do expediente da barbearia (09:00 às 20:00)
        if ($dataHora->format('H:i') < self::HORARIO_INICIO || $dataHora->format('H:i') >= self::HORARIO_FIM) {
            return false; // Fora do horário de funcionamento da barbearia
        }

        // Verificando se o horário já está ocupado por outro agendamento
        $agendamentoExistente = Schedulling::where('barbeiro_id', $this->id)
            ->where('data_hora', $dataHora)
            ->exists();

        return !$agendamentoExistente; // Retorna verdadeiro se o horário estiver disponível
    }

}
