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
        Schema::disableForeignKeyConstraints();
    
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['ready to wear', 'tailoring'])->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
            $table->index(['name', 'category_id']);
        });
    
        Schema::enableForeignKeyConstraints();
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category');
    }
};
