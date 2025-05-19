<?php

namespace App\Models\Productos;

use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = 'prd_detalles_productos';

    protected $fillable = [
        'id_producto',
        'autor',
        'id_genero',
        'codigo_producto',
        'color',
        'dimensiones',
        'peso',
        'material',
        'isbn',
        'anio_publicacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'id_genero');
    }
}
