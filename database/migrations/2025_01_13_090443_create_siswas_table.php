<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->date('date_of_birth')->nullable();;
            $table->string('place_of_birth',100)->nullable();;
            $table->string('mother_name',100)->nullable();
            $table->string('father_name',100)->nullable();
            $table->string('gender',10);
            $table->string('nis',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
