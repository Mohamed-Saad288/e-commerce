<?php

use App\Modules\Base\Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId("product_variation_id")->nullable()->constrained('product_variations')->onDelete('cascade');
            $table->foreignId("user_id")->nullable()->constrained('users')->onDelete('cascade');
            $table->integer("rate")->nullable()->default(0);
            $table->text("comment")->nullable();
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
