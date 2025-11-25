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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->tinyInteger('type')->default(1)->comment('1=>physical , 2=>digital , 3=>service');
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('requires_shipping')->default(true);
            $table->integer('stock_quantity')->default(0);

            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->unique(['product_id', 'locale']);
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
