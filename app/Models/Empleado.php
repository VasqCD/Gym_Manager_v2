<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraBitacora;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo para la gestión de empleados del gimnasio
 *
 * @property int $id Identificador único del empleado
 * @property string $nombre_completo Nombre completo del empleado
 * @property string $dni Documento de identidad del empleado
 * @property string $telefono Número de teléfono del empleado
 * @property string $direccion Dirección física del empleado
 * @property string $email Correo electrónico del empleado
 * @property string $cargo Cargo o puesto del empleado
 * @property float $salario Salario del empleado
 * @property \DateTime $fecha_contratacion Fecha de contratación del empleado
 * @property string $horario_trabajo Horario de trabajo asignado
 * @property string $tipo_contrato Tipo de contrato laboral
 * @property string $numero_seguro_social Número de seguro social
 * @property string $contacto_emergencia Nombre del contacto de emergencia
 * @property string $telefono_emergencia Teléfono del contacto de emergencia
 * @property boolean $estado Estado actual del empleado (activo/inactivo)
 * @property \DateTime $created_at Fecha de creación del registro
 * @property \DateTime $updated_at Fecha de última actualización
 * @property \DateTime|null $deleted_at Fecha de eliminación suave
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Empleado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Empleado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Empleado query()
 * @method static \Illuminate\Database\Eloquent\Builder|Empleado onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Empleado withTrashed()
 *
 * @package App\Models
 */
class Empleado extends Model
{
    use SoftDeletes, RegistraBitacora, HasFactory;
    
    protected $perPage = 10;

    /**
     * Los atributos que son asignables en masa. Esto significa que se pueden asignar a
     * través de la creación o actualización en masa.
     *
     * @var array<int, string>
     */
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
        'activo'
    ];

    /**
     * Los atributos que deben ser convertidos a fechas
     * Y los que deben ser convertidos a tipos de datos específicos o nativos
     *
     * @var array<string>
     */
    protected $dates = [
        'fecha_contratacion',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos de datos específicos o nativos
     *
     * @var array<string>
     */
    protected $casts = [
        'fecha_contratacion' => 'datetime',
        'salario' => 'decimal:2',
        'activo' => 'boolean'
    ];
}