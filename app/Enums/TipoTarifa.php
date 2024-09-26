<?php

namespace App\Enums;

enum TipoTarifa: string
{
    case FIXO = 'Fixo';
    case MOVEL = 'Movel';
    case INTERNACIONAL = 'Internacional';
    case ENTRADA = 'Entrada';
    case SERVICO = 'Servico';
    case OUTROS = 'Outros';
    case GRATUITO = 'Gratuito';

    public static function options(): array
    {
        return [
            ['label' => self::FIXO->value, 'value' => self::FIXO->value],
            ['label' => self::MOVEL->value, 'value' => self::MOVEL->value],
            ['label' => self::INTERNACIONAL->value, 'value' => self::INTERNACIONAL->value],
            ['label' => self::ENTRADA->value, 'value' => self::ENTRADA->value],
            ['label' => self::SERVICO->value, 'value' => self::SERVICO->value],
            ['label' => self::OUTROS->value, 'value' => self::OUTROS->value],
            ['label' => self::GRATUITO->value, 'value' => self::GRATUITO->value],
        ];
    }

    public static function optionsWithAll(): array
    {
        return array_merge(
            [['label' => 'Todos', 'value' => 'All']],
            self::options()
        );
    }
}
