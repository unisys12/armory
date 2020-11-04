<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Helpers\RequestDataHelper;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemsPath = DB::table('manifests')
            ->where('key', 'DestinyInventoryItemDefinition')
            ->first();

        $fullPath = 'https://www.bungie.net' . $itemsPath->value;

        echo "#### Fetching DestinyInventoryItemDefinition #### \n";

        $request = Http::withHeaders(['X_API_KEY' => env('BUNGIE_KEY')])->get(
            $fullPath
        );

        if ($request->getStatusCode() == '200') {
            echo "Got a 200 Status Code! \n";

            $stacker = new RequestDataHelper($request);
            $stack = $stacker->stack();
            $stack_count = count($stack);

            foreach ($stack as $ref) {
                DB::table('items')->insert([
                    'name' => $ref['displayProperties']['name'],
                    'description' => $ref['displayProperties']['description'],
                    'iconPath' => $ref['displayProperties']['icon'] ?? '',
                    'collectibleHash' => $ref['collectibleHash'] ?? '',
                    'screenshot' => $ref['screenshot'] ?? '',
                    'itemTypeDisplayName' => $ref['itemTypeDisplayName'] ?? '',
                    'itemTypeAndTierDisplayName' =>
                        $ref['itemTypeAndTierDisplayName'] ?? '',
                    'loreHash' => $ref['loreHash'] ?? '',
                    'itemType' => $ref['itemType'] ?? '',
                    'itemSubType' => $ref['itemSubType'] ?? '',
                    'classType' => $ref['classType'] ?? '',
                    'seasonHash' => $ref['seasonHash'] ?? '',
                    'hash' => $ref['hash'],
                ]);
                echo '.';
            }

            echo "Seeded ${stack_count} items in the database! \n";
            echo "\n";
        } else {
            echo $request->getStatusCode();
        }

        echo "Seeded ${stack_count} items in items table... \n";
        echo ' \n';
    }
}
