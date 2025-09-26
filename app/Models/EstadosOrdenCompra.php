<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EstadoOrdenCompra extends Enum
{
    const PENDIENTE = 'pendiente';
    const PENDIENTE_VALIDACION = 'pendiente_validacion'; // Nuevo estado para que el Encargado de Stock valide.
    const PENDIENTE_CONFIRMACION = 'pendiente_confirmacion'; // Nuevo estado para que el Gerente confirme.
    const REALIZABLE = 'realizable';
    const NO_REALIZABLE = 'no_realizable';
    const EJECUTABLE = 'ejecutable';
    const NO_EJECUTABLE = 'no_ejecutable';
    const COMPLETADA = 'completada';
}