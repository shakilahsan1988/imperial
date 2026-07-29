<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $name = 'Dr. '.$this->faker->unique()->firstName().' '.$this->faker->lastName();

        return [
            'code' => (string) $this->faker->unique()->numberBetween(1000000000000, 9999999999999),
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(6)),
            'phone' => null,
            'email' => null,
            'address' => 'Imperial Private Health Care BD Limited',
            'designation' => 'Consultant',
            'qualification' => 'MBBS',
            'bio' => null,
            'image' => null,
            'commission' => 0,
            'consultation_fee' => 0,
            'video_consultation_available' => false,
            'status' => true,
        ];
    }

    /**
     * A doctor with no personal photo, so the shared avatar applies.
     */
    public function withoutImage(): static
    {
        return $this->state(fn () => ['image' => null]);
    }

    /**
     * A doctor whose stored path points at a file that does not exist.
     */
    public function withBrokenImage(): static
    {
        return $this->state(fn () => ['image' => 'uploads/doctors/999999/'.Str::uuid()->toString().'.jpg']);
    }
}
