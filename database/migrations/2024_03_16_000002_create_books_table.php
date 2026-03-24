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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('publisher');
            $table->integer('year_published');
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
            
            // Index untuk performa pencarian
            $table->index(['title', 'author']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
