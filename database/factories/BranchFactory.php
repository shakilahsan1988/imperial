<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        $name = 'Imperial Private Health Care (BD) Ltd. ('.$this->faker->unique()->city().' Branch)';

        return [
            'name' => $name,
            'title' => $name,
            'slug' => Str::slug($name),
            'address' => $this->faker->address(),
            'phone' => null,
        ];
    }

    /**
     * The real Hatirpool branch, named exactly as the database holds it.
     */
    public function hatirpool(): static
    {
        $name = 'Imperial Private Health Care (BD) Ltd. (Hatirpool Branch)';

        return $this->state(fn () => [
            'name' => $name,
            'title' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    /**
     * The real Banglamotor branch, named exactly as the database holds it.
     */
    public function banglamotor(): static
    {
        $name = 'Imperial Private Health Care (BD) Ltd. (Banglamotor Branch)';

        return $this->state(fn () => [
            'name' => $name,
            'title' => $name,
            'slug' => Str::slug($name),
        ]);
    }
}
