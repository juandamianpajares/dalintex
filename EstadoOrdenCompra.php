<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EstadoOrdenCompra extends Enum
{
    const PENDIENTE = 'pendiente';
    const REALIZABLE = 'realizable';
    const NO_REALIZABLE = 'no_realizable';
    const EJECUTABLE = 'ejecutable';
    const NO_EJECUTABLE = 'no_ejecutable';
    const COMPLETADA = 'completada';
}