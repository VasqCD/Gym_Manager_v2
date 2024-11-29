<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraBitacora;

use Illuminate\Database\Eloquent\Model;

class InformacionEmpresa extends Model
{
    use SoftDeletes, RegistraBitacora;
    
    protected $table = 'informacion_empresa';
    protected $perPage = 10;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'rtn',
        'logo',
        'descripcion',
        'horario',
        'redes_sociales'
    ];
}
