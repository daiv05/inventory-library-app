<?php

namespace App\Http\Controllers\Seguridad\Auth;

use App\Enums\EstadosEnum;
use App\Enums\GeneralEnum;
use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Mail\RegistrationRequestResponseMail;
use App\Models\Registro\Persona;
use App\Models\Seguridad\AuthVerifiedEmail;
use App\Models\Seguridad\SolicitudRegistro;
use App\Models\Seguridad\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthRegistrationController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function registration(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:50|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
                'email' => 'required|string|email|max:50|unique:users,email',
                'password' => 'required|string|min:8|max:50',
                'nombre' => 'string|max:50|regex:/^[a-zA-Z\sáéíóúñÁÉÍÓÚÑ]+$/',
                'apellido' => 'string|max:50|regex:/^[a-zA-Z\sáéíóúñÁÉÍÓÚÑ]+$/',
                'identificacion' => 'string|max:20|regex:/^[a-zA-Z0-9\-]+$/',
            ], [
                'username.regex' => 'El usuario solo puede contener letras, números y guiones bajos',
                'username.max' => 'El usuario no puede exceder los 50 caracteres',
                'username.unique' => 'Ya existe un usuario registrado con este /usuario',
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico no es válido',
                'email.max' => 'El correo electrónico no puede exceder los 50 caracteres',
                'email.unique' => 'Ya existe un usuario registrado con este correo electrónico',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.max' => 'La contraseña no puede exceder los 50 caracteres',
                'nombre.regex' => 'Caracteres no válidos en el nombre',
                'nombre.max' => 'Los nombres no pueden exceder los 50 caracteres',
                'apellido.regex' => 'Caracteres no válidos en el apellido',
                'apellido.max' => 'Los apellidos no pueden exceder los 50 caracteres',
                'identificacion.regex' => 'La identificación solo puede contener letras, números y guiones',
                'identificacion.max' => 'La identificación no puede exceder los 20 caracteres'
            ]);

            if ($validator->fails()) {
                return $this->validationError('Ocurrió un error de validación', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $validatedData = $validator->validated();

            DB::beginTransaction();

            $persona = Persona::create([
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'identificacion' => $validatedData['identificacion'],
                'activo' => true,
            ]);

            $usuario = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'id_persona' => $persona->id,
                'id_estado' => EstadosEnum::ACTIVO->value,
                'activo' => true
            ]);

            // Asignar rol por defecto
            $usuario->assignRole(RolesEnum::JEFE_INVENTARIO->value);

            DB::commit();

            return $this->success('Registro completado', $usuario, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Error al intentar registrar', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
