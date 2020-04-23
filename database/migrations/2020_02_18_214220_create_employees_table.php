<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->text('password');
            $table->text('login_token')->nullable();
            $table->datetime('login_token_created')->nullable();
            $table->text('push_notification_token')->nullable();
        });
        \DB::statement('ALTER TABLE employee AUTO_INCREMENT = 30000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
