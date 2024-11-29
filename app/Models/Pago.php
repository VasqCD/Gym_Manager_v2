<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
use Carbon\Carbon;

/**
 * Class Pago
 *
 * @property $id
 * @property $cliente_id
 * @property $fecha_pago
 * @property $total
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property Pagodetall[] $pagodetalls
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pago extends Model
{
    use RegistraBitacora;

    protected $perPage = 10;

    // Eager loading de relaciones (relaciones que se cargarán automáticamente)
    protected $with = ['cliente', 'detalles.membresia'];
    protected $fillable = ['cliente_id', 'fecha_pago', 'total'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id', 'id')
            ->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalles()
    {
        return $this->hasMany(\App\Models\Pagodetall::class, 'pago_id', 'id');
    }

    public function getDiasRestantesAttribute()
    {
        $detalle = $this->detalles->first();
        if (!$detalle) return 0;

        $duracion = $detalle->membresia->duracion;
        $fechaLimite = Carbon::parse($this->fecha_pago)->addDays($duracion);
        $diasRestantes = Carbon::now()->diffInDays($fechaLimite, false);

        // Si la fecha de pago es hoy, devolver la duración completa
        if (Carbon::parse($this->fecha_pago)->isToday()) {
            return $duracion;
        }

        return (int)$diasRestantes;
    }
}
