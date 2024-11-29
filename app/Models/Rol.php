<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Rol
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property Rolporpermiso[] $rolporpermisos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rol extends Model
{
    use SoftDeletes, RegistraBitacora;

    protected $perPage = 10;
    protected $table = 'rols';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion'];

/**
     * Obtiene los permisos del rol a través de la tabla pivote
     */
    public function rolporpermisos()
    {
        return $this->hasMany(Rolporpermiso::class, 'rol_id', 'id');
    }

    /**
     * Obtiene los permisos asociados al rol
     */
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rolporpermisos', 'rol_id', 'permiso_id');
    }

    /**
     * Verifica si el rol tiene un permiso específico
     */
    public function hasPermiso($permisoNombre)
    {
        return $this->permisos()->where('nombre', $permisoNombre)->exists();
    }
}
