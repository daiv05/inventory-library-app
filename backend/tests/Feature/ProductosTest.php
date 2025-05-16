<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Productos\Producto;
use App\Models\Productos\Categoria;
use App\Models\Catalogo\Estado;
use App\Models\Registro\Persona;
use App\Models\Seguridad\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductosTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->seed();
    }

    public function test_puede_obtener_lista_de_productos()
    {
        $user = User::find(1);
        // Autenticar al usuario para las pruebas
        $token = JWTAuth::fromUser($user);

        // Crear una categoría y un estado
        $categoria = Categoria::factory()->create();
        $estado = Estado::factory()->create();

        // Crear algunos productos de prueba
        Producto::factory()->count(3)->create([
            'id_categoria' => $categoria->id,
            'id_estado' => $estado->id
        ]);

        // Hacer la petición GET al endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/inventario/productos');


        // Verificar la respuesta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'descripcion',
                        'precio_actual',
                        'stock_actual'
                    ]
                ]
            ]);
    }

    // public function test_puede_obtener_un_producto_por_id()
    // {
    //     $user = User::find(1);

    //     // Autenticar al usuario para las pruebas
    //     $token = JWTAuth::fromUser($user);

    //     // Crear una categoría y un estado
    //     $categoria = Categoria::factory()->create();
    //     $estado = Estado::factory()->create();

    //     // Crear un producto de prueba
    //     $producto = Producto::factory()->create([
    //         'id_categoria' => $categoria->id,
    //         'id_estado' => $estado->id
    //     ]);

    //     // Hacer la petición GET al endpoint
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->getJson('/api/inventario/productos/' . $producto->id);

    //     // Verificar la respuesta
    //     $response->assertStatus(200)
    //         ->assertJsonStructure([
    //             'success',
    //             'message',
    //             'data' => [
    //                 'id',
    //                 'nombre',
    //                 'descripcion',
    //                 'precio_actual',
    //                 'stock_actual',
    //             ]
    //         ])
    //         ->assertJson([
    //             'success' => true,
    //             'data' => [
    //                 'id' => $producto->id,
    //                 'nombre' => $producto->nombre,
    //                 'descripcion' => $producto->descripcion,
    //                 'precio_actual' => $producto->precio_actual,
    //                 'stock_actual' => $producto->stock_actual,
    //             ]
    //         ]);
    // }
}
