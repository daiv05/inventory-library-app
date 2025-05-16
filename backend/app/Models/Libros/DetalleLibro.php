<?php

namespace App\Models\Libros;

use App\Models\Productos\Categoria;
use App\Models\Productos\Producto;
use Illuminate\Database\Eloquent\Model;

class DetalleLibro extends Model
{
    protected $table = 'lib_detalles_libros';

    protected $fillable = [
        'id_producto',
        'id_autor',
        'id_categoria',
        'isbn',
        'anio_publicacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'id_autor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
