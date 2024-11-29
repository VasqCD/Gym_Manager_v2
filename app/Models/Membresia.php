<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Membresia
 *
 * @property $id
 * @property $tipo
 * @property $descripcion
 * @property $costo
 * @property $duracion
 * @property $created_at
 * @property $updated_at
 *
 * @property Pagodetall[] $pagodetalls
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Membresia extends Model
{
    use SoftDeletes, RegistraBitacora;
    
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo', 'descripcion', 'costo', 'duracion'];

    protected $casts = [
        'costo' => 'decimal:2',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagodetalls()
    {
        return $this->hasMany(Pagodetall::class, 'membresia_id', 'id');
    }
    
}
