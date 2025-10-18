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
        Schema::table('home_section_products', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['product_id']);

            // Then drop the column
            $table->dropColumn('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_section_products', function (Blueprint $table) {
            // Recreate the column
            $table->unsignedBigInteger('product_id')->nullable();

            // Recreate the foreign key
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }
};
