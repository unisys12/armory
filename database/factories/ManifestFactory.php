<?php

namespace Database\Factories;

use App\Models\Manifest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class ManifestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manifest::class;

    /**
     * Fetch a recent version of the Destiny 2 Manifest
     * 
     * @return array
     */
    private function _fetchManifest()
    {
        $request = Http::withHeaders(
            ['X_API_KEY' => env('BUNGIE_KEY')]
        )->get('http://www.bungie.net/Platform/Destiny2/Manifest/');

        if ($request->fail()) {
            $request->throw();
        }

        dd($request);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            $this->_fetchManifest()
        ];
    }
}
