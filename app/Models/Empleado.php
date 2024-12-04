<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraBitacora;

/**
 * Class Empleado
 *
 * @property $id
 * @property $nombre_completo
 * @property $dni
 * @property $telefono
 * @property $direccion
 * @property $email
 * @property $cargo
 * @property $salario
 * @property $fecha_contratacion
 * @property $horario_trabajo
 * @property $tipo_contrato
 * @property $numero_seguro_social
 * @property $contacto_emergencia
 * @property $telefono_emergencia
 * @property $estado
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Empleado extends Model
{
    use SoftDeletes, RegistraBitacora;
    
    protected $perPage = 10;

    protected $fillable = [
        'nombre_completo',
        'dni',
        'telefono',
        'direccion',
        'email',
        'cargo',
        'salario',
        'fecha_contratacion',
        'horario_trabajo',
        'tipo_contrato',
        'numero_seguro_social',
        'contacto_emergencia',
        'telefono_emergencia',
        'estado'
    ];

    protected $dates = [
        'fecha_contratacion',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha_contratacion' => 'datetime',
        'salario' => 'decimal:2',
        'activo' => 'boolean'
    ];
}