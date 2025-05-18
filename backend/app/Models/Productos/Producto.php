<?php

namespace App\Models\Productos;

use App\Models\Catalogo\Estado;
use App\Models\Libros\DetalleLibro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'prd_productos';

    protected $fillable = [
        'nombre',
        'id_categoria',
        'id_estado',
        'nombre',
        'descripcion',
        'precio_actual',
        'stock_actual',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function detalleProducto()
    {
        return $this->hasOne(DetalleProducto::class, 'id_producto');
    }

}
