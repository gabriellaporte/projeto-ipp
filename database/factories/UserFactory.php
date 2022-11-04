<?php

namespace Database\Factories;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['M', 'F']);

        return [
            'name' => $this->faker->name($gender == 'M' ? 'male' : 'female'),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'gender' => $gender,
            'profile_picture' => $gender == 'M' ? 'img/avatars/no_avatar_male.png' : 'img/avatars/no_avatar_female.png',
            'mobile_phone' => $this->faker->cellphoneNumber(),
            'birth_date' => $this->faker->dateTimeBetween('1940-01-01', '2012-12-31'),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Email
            $name = explode(' ', str_replace('.', '', $user->name));
            $name = strtolower(implode('.', $name));
            $user->update(['email' => $name . '@gmail.com']);

            // Cargo
            $user->assignRole('Membro');

            // Notificações

        });
    }
}
