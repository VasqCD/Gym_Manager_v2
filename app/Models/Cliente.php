<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraBitacora;

/**
 * Modelo para la gestión de clientes del gimnasio
 *
 * @property int $id Identificador único del cliente
 * @property string $nombre_completo Nombre completo del cliente
 * @property string $dni Documento de identidad del cliente
 * @property string $telefono Número de teléfono del cliente
 * @property string $direccion Dirección física del cliente
 * @property string $email Correo electrónico del cliente
 * @property \DateTime $fecha_nacimiento Fecha de nacimiento del cliente
 * @property string $genero Género del cliente
 * @property string $contacto_emergencia Nombre del contacto de emergencia
 * @property string $telefono_emergencia Teléfono del contacto de emergencia
 * @property string $condiciones_medicas Condiciones médicas relevantes
 * @property \DateTime $fecha_registro Fecha de registro en el gimnasio
 * @property boolean $estado Estado actual del cliente
 * @property \DateTime $created_at Fecha de creación del registro
 * @property \DateTime $updated_at Fecha de última actualización
 * @property \DateTime|null $deleted_at Fecha de eliminación suave
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Pago[] $pagos Relación con los pagos del cliente
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente withTrashed()
 *
 * @package App\Models
 */
class Cliente extends Model
{
    use SoftDeletes, RegistraBitacora;
    use HasFactory;
    use RegistraBitacora;

    protected $perPage = 10;

    /**
     * Los atributos que son asignables en masa. Esto significa que se pueden asignar a
     * través de la creación o actualización en masa.
     * fillable significa que se pueden asignar a través de la creación o actualización en masa.
     *
     * @var array<int, string>
     */
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

    /**
     * Los atributos que deben ser convertidos a fechas
     * Y los que deben ser convertidos a tipos de datos específicos o nativos
     *
     * @var array<string>
     */
    protected $dates = [
        'fecha_nacimiento',
        'fecha_registro',
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
        'estado' => 'boolean',
        'fecha_nacimiento' => 'datetime',
        'fecha_registro' => 'datetime'
    ];

    /**
     * La función pagos() establece una relación entre el modelo Cliente y el modelo Pago
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Relación con las membresías a través de los detalles de pago
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function membresias()
    {
        return $this->hasManyThrough(
            Membresia::class,
            Pagodetall::class,
            'pago_id', // Llave foránea en pagodetalls
            'id', // Llave primaria en membresias
            'id', // Llave primaria en clientes
            'membresia_id' // Llave foránea en pagodetalls
        )->whereHas('pago', function ($query) {
            $query->where('cliente_id', $this->id);
        });
    }
}
