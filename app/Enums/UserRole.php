<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case RESELLER = 'reseller';
    case CUSTOMER = 'customer';
    case OPERATOR = 'operator';
    case VIEWER = 'viewer';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrador',
            self::MANAGER => 'Gerente',
            self::RESELLER => 'Revenda',
            self::CUSTOMER => 'Cliente',
            self::OPERATOR => 'Operador',
            self::VIEWER => 'Visualizador',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::ADMIN => 'Acesso total ao sistema',
            self::MANAGER => 'Gerenciamento de operações',
            self::RESELLER => 'Gerencia seus próprios clientes com markup',
            self::CUSTOMER => 'Acesso restrito aos dados do cliente',
            self::OPERATOR => 'Acesso operacional',
            self::VIEWER => 'Somente visualização',
        };
    }

    /**
     * Verifica se a role pode ver custos de compra
     */
    public function canSeeCosts(): bool
    {
        return match($this) {
            self::ADMIN, self::MANAGER => true,
            default => false,
        };
    }

    /**
     * Verifica se a role pode gerenciar clientes
     */
    public function canManageCustomers(): bool
    {
        return match($this) {
            self::ADMIN, self::MANAGER, self::RESELLER => true,
            default => false,
        };
    }

    /**
     * Verifica se a role tem acesso restrito por reseller
     */
    public function hasResellerRestriction(): bool
    {
        return $this === self::RESELLER;
    }
}
