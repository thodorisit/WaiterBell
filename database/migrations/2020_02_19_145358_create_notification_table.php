<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');
            $table->bigInteger('label_id')->nullable()->references('id')->on('label');
            $table->string('title', 70)->index();
            $table->text('body')->nullable();
            $table->text('icon')->nullable();
            $table->text('open_url')->nullable();
            $table->char('state',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
