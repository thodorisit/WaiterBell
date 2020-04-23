<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PivotLabelEmployee extends Migration {
    
    public function up() {
        Schema::create('pivot_label_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->nullable()->references('id')->on('business');//->onDelete('cascade');
            $table->bigInteger('employee_id')->references('id')->on('employee');
            $table->bigInteger('label_id')->references('id')->on('label');
        });
    }

    public function down() {
        Schema::dropIfExists('pivot_label_employee');
    }

}
