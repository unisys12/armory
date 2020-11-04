<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Helpers\RequestDataHelper;

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

        echo "#### Fetching Destiny 2 Manifest #### \n";

        if ($request->getStatusCode() == '200') {
            echo "Got a 200 Status Code! \n";

            $stacker = new RequestDataHelper($request);
            $stack = $stacker->stack();
            $stack_count = count($stack);
        } else {
            echo "There was an error: {$request->getStatusCode()} \n";
            return;
        }
        /**
         * array_keys($stack['Response'])
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
            ['key' => 'version', 'value' => $stack['Response']['version']],
            [
                'key' => 'mobileWorldContentPaths',
                'value' => $stack['Response']['mobileWorldContentPaths']['en'],
            ],
            [
                'key' => 'jsonWorldContentPaths',
                'value' => $stack['Response']['jsonWorldContentPaths']['en'],
            ],
            [
                'key' => 'DestinyInventoryItemDefinition',
                'value' =>
                    $stack['Response']['jsonWorldComponentContentPaths']['en'][
                        'DestinyInventoryItemDefinition'
                    ],
            ],
            [
                'key' => 'DestinyLoreDefinition',
                'value' =>
                    $stack['Response']['jsonWorldComponentContentPaths']['en'][
                        'DestinyLoreDefinition'
                    ],
            ],
            [
                'key' => 'DestinyCollectibleDefinition',
                'value' =>
                    $stack['Response']['jsonWorldComponentContentPaths']['en'][
                        'DestinyCollectibleDefinition'
                    ],
            ],
        ]);
    }
}
