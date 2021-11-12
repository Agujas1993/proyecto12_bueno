<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\UserProfile;
use http\Client\Curl\User;
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
        'password' => '123456*Sa',
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
            'password' => '123456*Sa',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);

        $response->assertRedirect('editar-perfil');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@gmail.es',
            'password' => '123456*Sa',
        ]);

        $this->assertDatabaseHas('user_profiles', [

            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);
    }
}