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
            $table->string('task_name', 128)->unique();
            $table->text('task');
            $table->longText('image')->nullable()->default(null);
            $table->text('solution');
            $table->unsignedBigInteger('batch_id')
                ->references('id')
                ->on('math_batches')
                ->onDelete('cascade');
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
