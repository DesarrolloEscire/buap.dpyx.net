<?php

use App\Models\MetadataValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMetadataValueRepositoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_value__repository', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repository_id');
            $table->unsignedBigInteger('metadata_value_id');

            $table
                ->foreign('repository_id')
                ->references('id')
                ->on('repositories')
                ->onDelete('CASCADE');

            $table
                ->foreign('metadata_value_id')
                ->references('id')
                ->on('metadata_values')
                ->onDelete('CASCADE');
        });

        MetadataValue::get()->each(function ($metadataValue) {
            DB::table('metadata_value__repository')->insert([
                'repository_id' => $metadataValue->repository_id,
                'metadata_value_id' => $metadataValue->id
            ]);
        });

        Schema::table('metadata_values', function (Blueprint $table) {
            $table->dropColumn('repository_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_value__repository');

        Schema::table('metadata_values', function (Blueprint $table) {
            $table->unsignedBigInteger('repository_id');

            $table
                ->foreign('repository_id')
                ->references('id')
                ->on('repositories')
                ->onDelete('CASCADE');
        });
    }
}
