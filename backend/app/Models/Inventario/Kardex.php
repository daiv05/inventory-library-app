<?php

namespace App\Models\Inventario;

use App\Models\Catalogo\TipoMovimiento;
use App\Models\Productos\Producto;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'inv_kardex';

    protected $fillable = [
        'id_producto',
        'id_tipo_movimiento',
        'id_usuario_registro',
        'cantidad',
        'precio_unitario',
        'observaciones',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro');
    }
}
