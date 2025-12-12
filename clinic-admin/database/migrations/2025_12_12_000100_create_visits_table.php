<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->string('reason');
            $table->dateTime('visit_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('visit_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
