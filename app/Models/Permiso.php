<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraBitacora;
/**
 * Class Permiso
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
class Permiso extends Model
{
    use RegistraBitacora;
    
    protected $perPage = 10;

    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Obtiene los roles asociados al permiso
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rolporpermisos', 'permiso_id', 'rol_id')
                    ->withTimestamps();
    }

    /**
     * Obtiene las asignaciones de roles y permisos
     */
    public function rolporpermisos()
    {
        return $this->hasMany(Rolporpermiso::class, 'permiso_id');
    }
}
