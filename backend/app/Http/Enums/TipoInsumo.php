<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static EMPAQUE()
 * @method static static MATERIA_PRIMA()
 */
final class TipoInsumo extends Enum
{
    const EMPAQUE = 'empaque';
    const MATERIA_PRIMA = 'materia_prima';
    const OTRO = 'otro';
}
?>