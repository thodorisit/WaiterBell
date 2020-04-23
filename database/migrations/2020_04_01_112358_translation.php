<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Translation extends Migration {

    public function up() {
        Schema::create('translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');
            $table->string('attribute')->index();
            $table->text('translations');
        });
    }

    public function down() {
        
    }
    
}
