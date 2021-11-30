<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function filterBy(array $filters)    //Para que sea un array sí o sí
    {
        $rules = [  //Reglas de validación
          'search' => 'filled',
          'state' => 'in:active,inactive',
          'role' => 'in:user,admin'
        ];

        $validator = Validator::make($filters, $rules); //Para validar fuera del request

        foreach ($validator->valid() as $name => $value) {
            $method = 'filterBy' . Str::studly($name);  //componer el método

            if (method_exists($this, $method)) {    //Para saber si existe el método
                $this->$method($value);
            }

        }
        return $this;
    }
    
    
    public function filterBySearch($search) //se le quita "scope" ya que al estar en la clase que extiende de builder no hace falta
    {
        if (empty($search)) {
            return $this;
        }

        return $this->where(function ($query) use ($search){
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%") //Para buscar por nombre completo
            ->orWhere('email','LIKE' ,"%{$search}%")
                ->orWhereHas('team', function ($query) use ($search){
                    $query->where('name', 'LIKE',"%{$search}%");
                    //Hacer test comprobar dos filtros simultáneos
                });
        });
    }
    public function filterByState($state)//Hay que ponerle 'filterBy' antes ya que lo estamos definiendo en el foreach
    {
        if($state == 'active') {
            return $this->where('active', true);
        }

        if($state == 'inactive') {
            return $this->where('active', false);
        }
        return $this;
    }

    public function filterByRole($role)
    {
        if (in_array($role, ['admin', 'user'])) {
            return $this->where('role', $role);
        }

        return $this;
    }

}