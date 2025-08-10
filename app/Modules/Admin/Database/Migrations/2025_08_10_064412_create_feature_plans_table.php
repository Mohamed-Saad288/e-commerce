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
        Schema::create('feature_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("feature_id")->nullable()->constrained()->onDelete("set null");
            $table->foreignId("plan_id")->nullable()->constrained()->onDelete("set null");
            $table->string("feature_value")->nullable();
            $table->boolean("is_active")->comment("1 = active , 0 = inactive")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_plans');
    }
};
