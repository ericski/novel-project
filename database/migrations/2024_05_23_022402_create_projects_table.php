<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('event_id')->nullable();
            $table->text('cover')->nullable();
            $table->boolean('censored')->default(false);
            $table->integer('goal');
            $table->boolean('goal_type')->default(true);
            $table->boolean('active')->default(false);
            $table->enum('status', ['pending', 'in progress', 'shelved', 'abandoned', 'complete'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
