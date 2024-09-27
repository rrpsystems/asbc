<?php

namespace App\Enums;

enum DialStatus: string
{
    case ANSWERED = 'ANSWERED';
    case BUSY = 'BUSY';
    case NO_ANSWER = 'NO ANSWER';
    case CANCEL = 'CANCEL';
    case CONGESTION = 'CONGESTION';
    case CHANUNAVAIL = 'CHANUNAVAIL';
    case DONTCALL = 'DONTCALL';
    case TORTURE = 'TORTURE';
    case INVALIDARGS = 'INVALIDARGS';

    public function getDisposition(): string
    {
        return match ($this) {
            self::ANSWERED => 'Atendida',
            self::BUSY => 'Ocupada',
            self::NO_ANSWER => 'Não Atendida',
            self::CANCEL => 'Cancelada',
            self::CONGESTION => 'Congestionada',
            self::CHANUNAVAIL => 'Canal Indisponível',
            self::DONTCALL => 'Não Perturbe',
            self::TORTURE => 'Tortura',
            self::INVALIDARGS => 'Argumentos Inválidos',
        };
    }
}
