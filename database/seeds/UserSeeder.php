<?php

use App\{Profession, Skill, Team, User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private $professions;
    private $skills;
    private $teams;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fetchRelations();

        $this->createAdmin();

        $this->createRandomUser();
    }

    private function fetchRelations(): void
    {
        $this->professions = Profession::all();
        $this->skills = Skill::all();
        $this->teams = Team::all();

    }

    private function createAdmin()
    {
        $admin = User::create([
            'team_id' => $this->teams->firstWhere('name', 'IES Ingeniero')->id,
            'first_name' => 'Juan',
            'last_name' => 'Martínez',
            'email' => 'Juan@gmail.es',
            'password' => bcrypt('123456*Sa'),
            'role' => 'admin',
            'created_at' => now(),
            'active' => true
        ]);

        $admin->profile()->create([
            'bio' => 'Programador',
            'profession_id' => $this->professions->where('title', 'Desarrollador Back-End')->first()->id,
        ]);
    }

    private function createRandomUser(): void
    {
        foreach (range(1, 999) as $i) {
            $user = factory(User::class)->create([
                'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
                'active' =>  rand(0,4) ? true : false,
                'created_at' => now()->subDays(rand(1,90)), //le restamos entre 1 y 90 días aleatorios
            ]);

            $user->skills()->attach($this->skills->random(rand(0, 7)));

            $user->profile()->update(
                factory(App\UserProfile::class)->raw([
                    'profession_id' => rand(0, 2) ? $this->professions->random()->id : null
                ])
            );
        }
    }
}
