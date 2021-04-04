<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained('elections')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('election_faculties');
    }
}
