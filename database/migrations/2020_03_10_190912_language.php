<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Language extends Migration {

    public function up() {
        Schema::create('language', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');
            $table->string('name')->index()->nullable();
            $table->string('native_name')->nullable();
            $table->string('slug')->index()->nullable();
            $table->tinyInteger('is_default')->nullable();
        });
    }

    public function down() {
        
    }

}
