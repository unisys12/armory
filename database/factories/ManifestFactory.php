<?php

namespace Database\Factories;

use App\Models\Manifest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManifestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manifest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //
    }
}
