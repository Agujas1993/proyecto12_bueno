<?php

namespace App;

class UserFilter extends QueryFilter
{

    public function rules(): array
    {
        return[
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:user,admin'
        ];
    }

    public function filterBySearch($query, $search) //se le quita "scope" ya que al estar en la clase que extiende de builder no hace falta
    {
        return $query->where(function ($query) use ($search){
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%") //Para buscar por nombre completo
            ->orWhere('email','LIKE' ,"%{$search}%")
                ->orWhereHas('team', function ($query) use ($search){
                    $query->where('name', 'LIKE',"%{$search}%");
                    //Hacer test comprobar dos filtros simultáneos
                });
        });
    }

    public function filterByState($query, $state)//Hay que ponerle 'filterBy' antes ya que lo estamos definiendo en el foreach
    {
        return $query->where('active', $state == 'active');
    }

}