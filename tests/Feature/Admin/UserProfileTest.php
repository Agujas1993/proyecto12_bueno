<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\UserProfile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestHelpers;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Pepe',
        'email' => 'pepe@gmail.es',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/pepe',
    ];

    /** @test */
    public function a_user_can_edit_its_profile()
    {
        $user = factory(User::class)->create();
        $user->profile()->save(factory(UserProfile::class)->make());

        $newProfession = factory(Profession::class)->create();

        //$this->actingAs($user);

        $response = $this->get('editar-perfil');
        $response->assertStatus(200);

        $response = $this->put('editar-perfil', [
            'name' => 'Pepe',
            'email' => 'pepe@gmail.es',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);

        $response->assertRedirect('editar-perfil');

        $this->assertDatabaseHas('users', [
            'name' => 'Pepe',
            'email' => 'pepe@gmail.es',
        ]);

        $this->assertDatabaseHas('user_profiles', [

            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);
    }

    /** @test */
    public function the_user_cannot_change_its_role()
    {
        $user = factory(User::class)->create([
            'role' => 'user',
        ]);

        $response = $this->put('editar-perfil', $this->withData([
            'role' => 'admin'
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user'
        ]);
    }

    /** @test */
    public function the_user_cannot_change_its_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('123456*Sa'),
        ]);

        $response = $this->put('editar-perfil', $this->withData([
            'email' => 'pepe@gmail.es',
            'password' => bcrypt('new654321')
        ]));

        $response->assertRedirect();

        $this->assertCredentials([
            'email' => 'pepe@gmail.es',
            'password' => '123456*Sa' //NO BCRYPT NUNCA porque el assertCredential ya lo hace por defecto creo*
        ]);
    }
}
