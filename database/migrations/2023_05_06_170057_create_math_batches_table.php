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
        Schema::create('math_batches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->integer('max_points')->nullable()->default(null);
            $table->boolean('available')->default(false);
            $table->dateTime('publishing_at')->nullable()->default(null);
            $table->dateTime('closing_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('math_batches');
    }
};
