<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para el registro de cambios en la bitácora del sistema
 *
 * @property int $id Identificador único del registro
 * @property string $usuario Usuario que realizó la acción
 * @property string $tabla Tabla afectada por la acción
 * @property string $accion Tipo de acción realizada (CREATE/UPDATE/DELETE)
 * @property array $datos_antiguos Datos antes del cambio
 * @property array $datos_nuevos Datos después del cambio
 * @property string $ip Dirección IP desde donde se realizó la acción
 * @property \DateTime $created_at Fecha de creación del registro
 * @property \DateTime $updated_at Fecha de última actualización
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Bitacoracambio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bitacoracambio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bitacoracambio query()
 *
 * @method string getBadgeClass() Obtiene la clase CSS del badge según el tipo de acción
 * @return string Clase CSS correspondiente (success/warning/danger/info)
 *
 * @package App\Models
 */
class Bitacoracambio extends Model
{
    /**
     * La tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'bitacoracambios';
    
    /**
     * Número de elementos por página para la paginación
     */
    protected $perPage = 10;

    /**
     * Los atributos que son asignables en masa. Esto significa que se pueden asignar a
     * través de la creación o actualización en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'tabla',
        'accion',
        'datos_antiguos',
        'datos_nuevos',
        'ip'
    ];

    /**
     * Los atributos que deben ser convertidos a fechas
     * Y los que deben ser convertidos a tipos de datos específicos o nativos
     *
     * @var array<string>
     */
    protected $casts = [
        'datos_antiguos' => 'array',
        'datos_nuevos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Obtiene el tipo de badge según la acción (alertas)
     */
    public function getBadgeClass()
    {
        return match($this->accion) {
            'CREATE' => 'success',
            'UPDATE' => 'warning',
            'DELETE' => 'danger',
            default => 'info'
        };
    }
}
