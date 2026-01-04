<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'rule',
        'ativo',
        'customer_id',
        'reseller_id',
        'password',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'rule' => UserRole::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    /**
     * Verifica se o usuário é uma revenda
     */
    public function isReseller(): bool
    {
        return $this->rule === UserRole::RESELLER;
    }

    /**
     * Verifica se o usuário pode ver custos
     */
    public function canSeeCosts(): bool
    {
        return $this->rule->canSeeCosts();
    }

    /**
     * Verifica se o usuário pode gerenciar clientes
     */
    public function canManageCustomers(): bool
    {
        return $this->rule->canManageCustomers();
    }
}
