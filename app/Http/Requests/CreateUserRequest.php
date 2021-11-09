<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z áéíóúÁÉÍÓÚñÑ]+$/u',
            'email' => 'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'role' => '',
            'bio' => 'required',
            'twitter' => 'nullable|present|url',
            'profession_id' => [
                'nullable', 'present',
                Rule::exists('professions', 'id')->whereNull('deleted_at')
            ],
            'skills' => [
                'array',
                Rule::exists('skills', 'id'),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'name.regex' => 'No se permiten caracteres alfanuméricos, usa tu nombre real con o sin apellidos',
            'email.required' => 'El campo email es obligatorio',
            'password.regex' => 'La contraseña debe tener entre 6 y 12 caracteres, al menos un dígito, una minúscula,
            una mayúscula y un caracter no alfanumérico.',
            'email.regex' => 'El email no es válido, un ejemplo de email válido sería el siguiente: josito1@gmail.com',
            'password.required' => 'El campo contraseña es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya existe en la BD',
            'profession_id.exists' => 'El id de la profesión no es válido',
        ];
    }

    public function createUser()
    {
        User::createUser($this->validated());
    }
}
