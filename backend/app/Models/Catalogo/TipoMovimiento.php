<?php

namespace App\Models\Catalogo;

use App\Models\Inventario\Kardex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;

    protected $table = 'ctl_tipos_movimientos';

    protected $fillable = [
        'nombre'
    ];

    public function kardex()
    {
        return $this->hasMany(Kardex::class, 'id_tipo_movimiento');
    }
}
