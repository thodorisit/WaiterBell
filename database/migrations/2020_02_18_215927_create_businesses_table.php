<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->text('password');
            $table->string('name')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->text('allowed_ips')->nullable();
            $table->char('state', 1)->nullable();
            $table->string('account_type')->nullable();
            $table->text('login_token')->nullable();
            $table->datetime('login_token_created')->nullable();
            $table->text('push_notification_token')->nullable();
        });
        \DB::statement('ALTER TABLE business AUTO_INCREMENT = 15000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business');
    }
}
