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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            
            $table->string('title');
            $table->text('description');
            $table->string('isbn')->nullable();
            
            $table->unsignedInteger('publish_year')->nullable();
            $table->unsignedInteger('number_of_pages');
            $table->unsignedInteger('number_of_copies');
            
            $table->decimal('price', 8, 2)->default(0.00);
            $table->string('cover_image');
            
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('set null');
            
            $table->foreign('publisher_id')
            ->references('id')
            ->on('publishers')
            ->onDelete('set null');
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
