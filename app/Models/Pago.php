<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes, RegistraBitacora;

    protected $perPage = 10;

    // Eager loading de relaciones
    protected $with = ['cliente', 'detalles.membresia'];

    // Campos asignables masivamente
    protected $fillable = [
        'cliente_id',
        'fecha_pago',
        'metodo_pago',
        'observaciones',
        'total'
    ];

    // Casteo de atributos
    protected $casts = [
        'fecha_pago' => 'datetime',
        'total' => 'decimal:2',
        'metodo_pago' => 'string'
    ];

    // Atributos que deben ser mutados a fechas
    protected $dates = [
        'fecha_pago',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relación con Cliente
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id')
            ->withTrashed();
    }

    /**
     * Relación con PagoDetalle
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalles()
    {
        return $this->hasMany(Pagodetall::class, 'pago_id');
    }

    /**
     * Calcula los días restantes de la membresía
     * @return int
     */
    public function getDiasRestantesAttribute()
    {
        // Obtener el detalle más reciente usando latest()
        $detalle = $this->detalles()->latest()->first();
        if (!$detalle) return 0;

        $duracion = (int)$detalle->membresia->duracion;
        $fechaInicio = Carbon::parse($this->fecha_pago)->startOfDay();
        $fechaLimite = $fechaInicio->copy()->addDays($duracion);

        // Si es el primer día, retornar la duración completa
        if ($fechaInicio->isToday()) {
            return $duracion;
        }

        // Calcular días restantes desde inicio del día actual
        $diasRestantes = Carbon::now()->startOfDay()->diffInDays($fechaLimite, false);

        return max(0, $diasRestantes);
    }

    /**
     * Scope para filtrar pagos por método de pago
     */
    public function scopePorMetodoPago($query, $metodo)
    {
        return $query->where('metodo_pago', $metodo);
    }

    /**
     * Scope para filtrar pagos por rango de fechas
     */
    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_pago', [$desde, $hasta]);
    }

    /**
     * Formatea el total como moneda
     */
    public function getTotalFormateadoAttribute()
    {
        return 'L. ' . number_format($this->total, 2);
    }
}

