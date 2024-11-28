<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraBitacora;

/**
 * Class Cliente
 *
 * @property $id
 * @property $nombre_completo
 * @property $dni
 * @property $telefono
 * @property $direccion
 * @property $email
 * @property $fecha_nacimiento
 * @property $genero
 * @property $contacto_emergencia
 * @property $telefono_emergencia
 * @property $condiciones_medicas
 * @property $fecha_registro
 * @property $estado
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Pago[] $pagos
 */
class Cliente extends Model
{
    use SoftDeletes, RegistraBitacora;
    use HasFactory;
    use RegistraBitacora;
    
    protected $perPage = 10;

    protected $fillable = [
        'nombre_completo',
        'dni',
        'telefono',
        'direccion',
        'email',
        'fecha_nacimiento',
        'genero',
        'contacto_emergencia',
        'telefono_emergencia',
        'condiciones_medicas',
        'fecha_registro',
        'estado'
    ];

    protected $dates = [
        'fecha_nacimiento',
        'fecha_registro',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_nacimiento' => 'datetime',
        'fecha_registro' => 'datetime'
    ];

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}