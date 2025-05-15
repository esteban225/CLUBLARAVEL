<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    use HasFactory;

    protected $table = 'prestamos';
    protected $fillable = [
        'monto_asignado',
        'asociados_id',
        'actividades_id',
        'fecha_prestamo',
        'interes',
        'estado'
    ];
    
    public function asociado()
    {
        return $this->belongsTo(Asociados::class, 'asociados_id');
    }

    public function pagos()
    {
        return $this->belongsTo(Pagos::class, 'prestsamos_id');
    }
}
