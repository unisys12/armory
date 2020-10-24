<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collectionsPath = DB::table('manifests')
            ->where('key', 'DestinyCollectibleDefinition')
            ->first();

        $fullPath = 'https://www.bungie.net' . $collectionsPath->value;

        echo "${fullPath}\n";

        $request = Http::withHeaders(['X_API_KEY' => env('BUNGIE_KEY')])->get(
            $fullPath
        );

        $stack = [];

        if ($request->getStatusCode() == '200') {
            echo "Got a 200 Status Code! \n";

            $body = $request->getBody();
            $size = $body->getSize();

            echo "Size is ${size} \n";

            $data = $body->read($size);
            $data_json = json_decode($data, true);
            $stack = [];
            foreach ($data_json as $data) {
                array_push($stack, $data);
            }

            $stack_count = count($stack);

            // $insertObject = [];

            foreach ($stack as $ref) {
                DB::table('collections')->insert([
                    'name' => $ref['displayProperties']['name'],
                    'description' => $ref['displayProperties']['description'],
                    'sourceString' => $ref['sourceString'],
                    'itemHash' => $ref['itemHash'],
                    'hash' => $ref['hash'],
                ]);
            }

            echo "Seeded ${stack_count} collections in the database! \n";

            // DB::table('collections')->insert([$insertObject]);
        } else {
            echo $request->getStatusCode();
        }
    }
}
