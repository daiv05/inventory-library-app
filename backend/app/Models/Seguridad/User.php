<?php

namespace App\Models\Seguridad;

use App\Models\Catalogo\Estado;
use App\Models\Registro\Persona;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory, HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [
        'username',
        'email',
        'password',
        'id_persona',
        'activo',
        'id_estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoles()
    {
        return $this->roles();
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'roles' => $this->getRoles()->first()->pluck('name'),
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }

    public function checkPermissions($permission = []): bool
    {
        return $this->hasAllPermissions($permission);
    }
}
