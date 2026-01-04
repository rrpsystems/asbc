<?php

namespace App\Enums;

enum TipoProduto: string
{
    case RAMAL_PABX = 'ramal_pabx';
    case LINK_DEDICADO = 'link_dedicado';
    case SERVIDOR_VOIP = 'servidor_voip';
    case LICENCA_SOFTWARE = 'licenca_software';
    case ARMAZENAMENTO = 'armazenamento';
    case OUTRO = 'outro';

    public function label(): string
    {
        return match($this) {
            self::RAMAL_PABX => 'Ramal PABX',
            self::LINK_DEDICADO => 'Link Dedicado',
            self::SERVIDOR_VOIP => 'Servidor VoIP',
            self::LICENCA_SOFTWARE => 'Licença de Software',
            self::ARMAZENAMENTO => 'Armazenamento',
            self::OUTRO => 'Outro',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::RAMAL_PABX => 'phone',
            self::LINK_DEDICADO => 'wifi',
            self::SERVIDOR_VOIP => 'server',
            self::LICENCA_SOFTWARE => 'key',
            self::ARMAZENAMENTO => 'database',
            self::OUTRO => 'cube',
        };
    }
}

