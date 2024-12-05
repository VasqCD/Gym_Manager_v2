<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * Este controlador es la clase base de todos los controladores de la aplicación
 * aportando funcionalidades comunes a todos ellos
 * 
 * @package App\Http\Controllers
 * 
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
