<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
/**
 * Class Pagodetall
 *
 * @property $id
 * @property $pago_id
 * @property $membresia_id
 * @property $cantidad
 * @property $subtotal
 * @property $created_at
 * @property $updated_at
 *
 * @property Membresia $membresia
 * @property Pago $pago
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pagodetall extends Model
{
    use RegistraBitacora;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pago_id', 'membresia_id', 'cantidad', 'subtotal'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membresia()
    {
        return $this->belongsTo(\App\Models\Membresia::class, 'membresia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pago()
    {
        return $this->belongsTo(\App\Models\Pago::class, 'pago_id', 'id');
    }
    
}
