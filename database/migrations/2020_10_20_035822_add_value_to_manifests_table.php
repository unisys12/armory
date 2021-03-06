<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueToManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manifests', function (Blueprint $table) {
            $table->string('key')->after('id');
            $table->string('value')->after('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manifests', function (Blueprint $table) {
            $table->dropColumn('value');
            $table->dropColumn('key');
        });
    }
}
