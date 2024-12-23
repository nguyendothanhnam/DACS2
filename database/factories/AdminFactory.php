<?php

namespace Database\Factories;
use App\Models\Roles;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Admin::class;
    public function definition(): array
    {
        return [
            'admin_name' => fake()->name(),
            'admin_email' => fake()->unique()->safeEmail(),
            'admin_phone' => '123456789',
            'admin_password' => '$2y$12$cTsZBT2V/QUrgmLEwWIoyO0fNWnqkpptEsXB65hnveVnems7gbNm6',
            // 'email_verified_at' => now(),
            // 'admin_password' => static::$password ??= Hash::make('password'),
            // 'remember_token' => Str::random(10),
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Admin $admin) {
            $roles = Roles::where('name', 'user')->get();
            $admin->roles()->sync($roles->pluck('id_roles')->toArray());
        });
    }
}
