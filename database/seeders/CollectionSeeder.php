<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Helpers\RequestDataHelper;

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

        echo "#### Fetching DestinyCollectibleDefinition #### \n";

        $request = Http::withHeaders(['X_API_KEY' => env('BUNGIE_KEY')])->get(
            $fullPath
        );

        if ($request->getStatusCode() == '200') {
            echo "Got a 200 Status Code! \n";

            $stacker = new RequestDataHelper($request);
            $stack = $stacker->stack();
            $stack_count = count($stack);

            foreach ($stack as $ref) {
                DB::table('collections')->insert([
                    'name' => $ref['displayProperties']['name'],
                    'description' => $ref['displayProperties']['description'],
                    'sourceString' => $ref['sourceString'],
                    'itemHash' => $ref['itemHash'],
                    'hash' => $ref['hash'],
                ]);
                echo '.';
            }

            echo "Seeded ${stack_count} collections in the database! \n";
            echo "\n";
        } else {
            echo $request->getStatusCode();
        }
    }
}
