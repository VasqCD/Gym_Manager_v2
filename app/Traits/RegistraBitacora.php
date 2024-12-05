<?php
// app/Traits/RegistraBitacora.php

namespace App\Traits;

use App\Models\Bitacoracambio;
use App\Models\User;

/**
 * Trait para el registro automático de cambios en la bitácora
 *
 * Este trait proporciona funcionalidad para registrar automáticamente
 * los cambios realizados en los modelos (crear, actualizar, eliminar)
 * en una tabla de bitácora.
 *
 * @package App\Traits
 */
trait RegistraBitacora
{
    /**
     * Inicializa los observadores del modelo
     *
     * Registra los eventos created, updated y deleted para
     * capturar automáticamente los cambios en el modelo.
     *
     * @return void
     */
    protected static function bootRegistraBitacora()
    {
        // Registrar creación
        static::created(function ($model) {
            self::registrarCambio('CREATE', $model);
        });

        // Registrar actualización
        static::updated(function ($model) {
            self::registrarCambio('UPDATE', $model);
        });

        // Registrar eliminación
        static::deleted(function ($model) {
            self::registrarCambio('DELETE', $model);
        });
    }

    /**
     * Registra un cambio en la bitácora
     *
     * @param string $accion Tipo de acción realizada (CREATE, UPDATE, DELETE)
     * @param mixed $model Instancia del modelo que fue modificado
     * @throws \Exception Si ocurre un error al registrar en la bitácora
     * @return void
     */
    protected static function registrarCambio($accion, $model)
    {
        try {
            Bitacoracambio::create([
                'usuario' => auth()->user()->name ?? 'Sistema',
                'tabla' => $model->getTable(),
                'accion' => $accion,
                'datos_antiguos' => $accion !== 'CREATE' ? json_encode($model->getOriginal()) : null,
                'datos_nuevos' => $accion !== 'DELETE' ? json_encode($model->getAttributes()) : null,
                'ip' => request()->ip()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar en bitácora: ' . $e->getMessage());
        }
    }
}