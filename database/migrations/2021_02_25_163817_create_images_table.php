<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("barang_id");
            $table->unsignedBigInteger("koperasi_id");
            $table->string('image');
            $table->string('name');
            $table->timestamps();
            $table->foreign("barang_id")->references("id")->on("barangs")->onCascade("delete");
            $table->foreign("koperasi_id")->references("id")->on("koperasis")->onCascade("delete");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
