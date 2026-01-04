<?php

namespace App\Enums;

enum AudioIdentifier: string
{
    case BLOQUEIO_ENTRADA = 'bloqueio_entrada';
    case BLOQUEIO_SAIDA = 'bloqueio_saida';


    public function label(): string
    {
        return match ($this) {
            self::BLOQUEIO_ENTRADA => 'Bloqueio Entrada',
            self::BLOQUEIO_SAIDA => 'Bloqueio Saida',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'label' => $case->label(),
            'value' => $case->value,
        ], self::cases());
    }
}
