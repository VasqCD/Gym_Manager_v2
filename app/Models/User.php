<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\RegistraBitacora;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo para la gestión de usuarios del sistema
 *
 * Esta clase representa a los usuarios del sistema y gestiona la autenticación,
 * roles y permisos. Implementa soft deletes para mantener histórico y
 * registra cambios en bitácora.
 *
 * @property int $id
 * @property string $name Nombre completo del usuario
 * @property string $email Correo electrónico único del usuario
 * @property string $password Contraseña encriptada
 * @property int $rol_id ID del rol asignado
 * @property string $remember_token Token para recordar sesión
 * @property \Carbon\Carbon $email_verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * 
 * @property-read \App\Models\Rol $rol Relación con el rol del usuario
 * 
 * @package App\Models
 */
class User extends Authenticatable
{
    use SoftDeletes, RegistraBitacora;

    use HasFactory, Notifiable;

    /**
     * Los atributos que son asignables masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * Los atributos que deben ocultarse en la serialización
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtiene el rol asociado al usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * La función `hasPermiso` verifica si un usuario tiene un permiso específico asignado basado en su
     * rol.
     * 
     * @param string $permisoNombre La función `hasPermiso` que proporcionaste es un método que verifica
     * si un usuario tiene un permiso específico basado en el nombre del permiso proporcionado como
     * `string`.
     * 
     * @return bool La función `hasPermiso` devuelve un valor booleano. Devuelve `true` si el usuario
     * tiene el permiso especificado (`string`) asignado a su rol, y `false` en caso contrario.
     */
    public function hasPermiso($permisoNombre): bool
    {
        // Verificar que el usuario tenga un rol asignado
        if (!$this->rol) {
            return false;
        }

        // Verificar que el permiso exista
        $permiso = \App\Models\Permiso::where('nombre', $permisoNombre)->first();
        if (!$permiso) {
            return false;
        }

        // Verificar si el rol tiene el permiso asignado
        return $this->rol->permisos()
            ->where('permisos.nombre', $permisoNombre)
            ->exists();
    }

   /**
     * La función `hasRol` verifica si un usuario tiene un rol específico asignado.
     * 
     * @param string $rolNombre La función `hasRol` que proporcionaste es un método que verifica si
     * un usuario tiene un rol específico asignado basado en el nombre del rol proporcionado como
     * `string`.
     * 
     * @return bool La función `hasRol` devuelve un valor booleano. Devuelve `true` si el usuario
     * tiene el rol especificado (`string`) asignado, y `false` en caso contrario.
     */
    public function hasRol($rolNombre)
    {
        return $this->rol->nombre === $rolNombre;
    }
}
