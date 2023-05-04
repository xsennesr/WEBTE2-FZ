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
        Schema::create('math_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name', 128);
            $table->string('task_name', 128)->unique();
            $table->text('task');
            $table->text('image')->nullable()->default(null);
            $table->text('solution');
            $table->integer('max_points')->nullable()->default(null);
            $table->boolean('available')->default(false);
            $table->dateTime('publishing_at')->nullable()->default(null);
            $table->dateTime('closing_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('math_tasks');
    }
};
