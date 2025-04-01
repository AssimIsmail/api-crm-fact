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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entreprise_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('pays')->nullable();
            $table->string('password');
            $table->boolean('status');
            $table->timestamp('last_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
