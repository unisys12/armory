<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ManifestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request = Http::withHeaders(['X_API_KEY' => env('BUNGIE_KEY')])->get(
            'http://www.bungie.net/Platform/Destiny2/Manifest/'
        );

        if ($request->getStatusCode() == '200') {
            echo "Got a 200 Status Code! \n";

            $body = $request->getBody();
            $size = $body->getSize();

            echo "Size is ${size} \n";

            $manifest = $body->read($size);
            $manifest_json = json_decode($manifest, true);
            $stack = [];

            foreach ($manifest_json as $data) {
                array_push($stack, $data);
            }
        } else {
            echo "There was an error: {$request->getStatusCode()} \n";
            return;
        }
        /**
         * array_keys($stack[0])
         * returns:
         * array:9 [
         *   0 => "version"
         *   1 => "mobileAssetContentPath"
         *   2 => "mobileGearAssetDataBases"
         *   3 => "mobileWorldContentPaths"
         *   4 => "jsonWorldContentPaths"
         *   5 => "jsonWorldComponentContentPaths"
         *   6 => "mobileClanBannerDatabasePath"
         *   7 => "mobileGearCDN"
         *   8 => "iconImagePyramidInfo"
         * ]
         */
        DB::table('manifests')->insert([
            ['key' => 'version', 'value' => $stack[0]['version']],
            [
                'key' => 'mobileWorldContentPaths',
                'value' => $stack[0]['mobileWorldContentPaths']['en'],
            ],
            [
                'key' => 'jsonWorldContentPaths',
                'value' => $stack[0]['jsonWorldContentPaths']['en'],
            ],
            [
                'key' => 'DestinyInventoryItemDefinition',
                'value' =>
                    $stack[0]['jsonWorldComponentContentPaths']['en'][
                        'DestinyInventoryItemDefinition'
                    ],
            ],
            [
                'key' => 'DestinyLoreDefinition',
                'value' =>
                    $stack[0]['jsonWorldComponentContentPaths']['en'][
                        'DestinyLoreDefinition'
                    ],
            ],
            [
                'key' => 'DestinyCollectibleDefinition',
                'value' =>
                    $stack[0]['jsonWorldComponentContentPaths']['en'][
                        'DestinyCollectibleDefinition'
                    ],
            ],
        ]);
    }
}
