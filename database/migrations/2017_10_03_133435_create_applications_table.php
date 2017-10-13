<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname', 128);
            $table->string('lastname', 128);
            $table->date('birthday');
            $table->string('address', 255);
            $table->string('city', 128);
            $table->string('zip', 6);
            $table->string('email', 320)->unique();
            $table->string('phone', 32);
            $table->string('receiptnb', 32);
            $table->string('img_receipt', 255);
            $table->string('img_ean', 255);
            $table->boolean('legal_1')->default(true);
            $table->boolean('legal_2')->default(true);
            $table->boolean('legal_3')->default(true);
            $table->boolean('legal_4')->default(true);

            $table->boolean('contest')->default(false);

            $table->string('title', 128)->nullable();
            $table->text('message', 500)->nullable();
            $table->string('img_tip', 255)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('video_type', 255)->nullable();
            $table->string('video_id', 255)->nullable();
            $table->string('video_image_id', 255)->nullable();

            $table->string('token', 32)->nullable();

            $table->timestamps();

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('whence_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('whence_id')->references('id')->on('whences')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
