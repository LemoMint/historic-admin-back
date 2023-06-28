<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description', 1024);

            $table->unsignedMediumInteger('publication_year')->nullable();
            $table->unsignedTinyInteger('publication_century')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('user_id');
            $table->foreignId('publishing_house_id');
            $table->foreignId('document_id');

            $table->index('publication_year');
            $table->index('publishing_house_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
