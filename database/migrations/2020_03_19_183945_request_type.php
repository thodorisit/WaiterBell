<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestType extends Migration {

    public function up() {
        Schema::create('request_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');
            $table->text('name')->nullable();
        });
    }

    public function down() {
        
    }

}
