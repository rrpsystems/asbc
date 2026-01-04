<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Formata número de telefone brasileiro
     */
    public static function format($numero, $tarifa = null)
    {
        // Remove caracteres não numéricos
        $numero = preg_replace('/[^0-9]/', '', $numero);
        $tamanho = strlen($numero);

        // Se for marcado como Internacional na tarifa, formata como internacional
        if ($tarifa === 'Internacional') {
            return self::formatInternacional($numero);
        }

        // Números internacionais (começam com 00)
        if (substr($numero, 0, 2) === '00') {
            $codigoPais = substr($numero, 2, 2);
            $resto = substr($numero, 4);
            return '+' . $codigoPais . ' ' . $resto;
        }

        // Números com 12 ou mais dígitos são internacionais (sem 00)
        if ($tamanho >= 12) {
            if (substr($numero, 0, 2) === '55') {
                // Número BR com código internacional (5511...)
                $ddd = substr($numero, 2, 2);
                $resto = substr($numero, 4);
                if (strlen($resto) === 9) {
                    return '+55 (' . $ddd . ') ' . substr($resto, 0, 5) . '-' . substr($resto, 5);
                }
                return '+55 (' . $ddd . ') ' . substr($resto, 0, 4) . '-' . substr($resto, 4);
            }
            return '+' . substr($numero, 0, 2) . ' ' . substr($numero, 2);
        }

        // 0800 e 0300
        if (in_array(substr($numero, 0, 4), ['0800', '0300'])) {
            return substr($numero, 0, 4) . '-' . substr($numero, 4, 3) . '-' . substr($numero, 7);
        }

        // Celular (11 dígitos)
        if ($tamanho === 11) {
            return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7);
        }

        // Fixo (10 dígitos)
        if ($tamanho === 10) {
            return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
        }

        // Outros casos - retorna original
        return $numero;
    }

    protected static function formatInternacional($numero)
    {
        $tamanho = strlen($numero);

        // Remove prefixo 00 se existir
        if (substr($numero, 0, 2) === '00') {
            $numero = substr($numero, 2);
            $tamanho = strlen($numero);
        }

        // Números internacionais - mantém formato simples
        if ($tamanho > 11) {
            if (substr($numero, 0, 2) === '55') {
                // Brasil internacional
                $ddd = substr($numero, 2, 2);
                $resto = substr($numero, 4);
                if (strlen($resto) === 9) {
                    return '+55 (' . $ddd . ') ' . substr($resto, 0, 5) . '-' . substr($resto, 5);
                }
                return '+55 (' . $ddd . ') ' . substr($resto, 0, 4) . '-' . substr($resto, 4);
            }
            return '+' . $numero;
        }

        return '+' . $numero;
    }
}
