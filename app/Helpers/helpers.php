<?php

use App\Helpers\PhoneHelper;

if (!function_exists('format_phone')) {
    /**
     * Formata número de telefone
     *
     * @param string $numero
     * @param string|null $tarifa
     * @return string
     */
    function format_phone($numero, $tarifa = null)
    {
        return PhoneHelper::format($numero, $tarifa);
    }
}
