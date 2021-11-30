<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function search($search) //se le quita "scope" ya que al estar en la clase que extiende de builder no hace falta
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
    public function byState($state)
    {
        if($state == 'active') {
            return $this->where('active', true);
        }

        if($state == 'inactive') {
            return $this->where('active', false);
        }
        return $this;
    }

    public function byRole($role)
    {
        if (in_array($role, ['admin', 'user'])) {
            return $this->where('role', $role);
        }

        return $this;
    }

}