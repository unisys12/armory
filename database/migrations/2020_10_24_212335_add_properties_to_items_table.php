<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertiesToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->after('name');
            $table->string('iconPath')->after('description');
            $table->string('collectibleHash')->after('iconPath');
            $table->string('screenshot')->after('collectibleHash');
            $table->string('itemTypeDisplayName')->after('screenshot');
            $table
                ->string('itemTypeAndTierDisplayName')
                ->after('itemTypeDisplayName');
            $table->string('loreHash')->after('itemTypeAndTierDisplayName');
            $table->string('itemType')->after('loreHash');
            $table->string('itemSubType')->after('itemType');
            $table->string('classType')->after('itemSubType');
            $table->string('seasonHash')->after('classType');
            $table->string('hash')->after('seasonHash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('iconPath');
            $table->dropColumn('collectibleHash');
            $table->dropColumn('screenshot');
            $table->dropColumn('itemTypeDisplayName');
            $table->dropColumn('itemTypeAndTierDisplayName');
            $table->dropColumn('loreHash');
            $table->dropColumn('itemType');
            $table->dropColumn('itemSubType');
            $table->dropColumn('classType');
            $table->dropColumn('seasonHash');
            $table->dropColumn('hash');
        });
    }
}
