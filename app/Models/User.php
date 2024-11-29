<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\RegistraBitacora;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes, RegistraBitacora;

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
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
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * Verifica si el usuario tiene un permiso específico
     */
    public function hasPermiso($permisoNombre): bool
    {
        if (!$this->rol) {
            return false;
        }

        if ($this->rol && $this->rol->nombre === 'Administrador') {
            return true;
        }

        return $this->rol->rolporpermisos()
            ->whereHas('permiso', function ($query) use ($permisoNombre) {
                $query->where('nombre', $permisoNombre);
            })->exists();
    }

    /**
     * Verifica si el usuario tiene un rol específico
     */
    public function hasRol($rolNombre)
    {
        return $this->rol->nombre === $rolNombre;
    }
}
