<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    protected $table = 'pagos';
    protected $fillable = [
        'prestamos_id',
        'valor_pago',
        'fecha_pago',
        'numero_cuota'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamos::class, 'prestamos_id');
    }
}
