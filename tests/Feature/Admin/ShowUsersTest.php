<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_displays_the_user_details()
    {
        $user = factory(User::class)->create([
            'first_name' => 'José',
            'last_name' => 'Martínez'
        ]);

        $this->get('usuarios/' . $user->id)
            ->assertStatus(200)
            ->assertSee($user->name); //no hay que cambiar a first_name por el getter que hicimos
    }

    /** @test */
    public function it_displays_a_404_error_if_the_user_is_not_found()
    {

        $this->withExceptionHandling();

        $this->get('usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }
}
