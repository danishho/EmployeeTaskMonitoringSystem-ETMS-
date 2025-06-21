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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('cascade'); // for task-level attachments
            $table->foreignId('task_progress_id')->nullable()->constrained()->onDelete('cascade'); // for progress-level attachment
            $table->string('filePath');
            $table->string('fileName');
            $table->string('fileType')->nullable();
            $table->dateTime('fileDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
