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
            $table->string("slug")->nullable();
            $table->foreignId("brand_id")->nullable()->constrained('brands')->onDelete('cascade');
            $table->foreignId("category_id")->nullable()->constrained('categories')->onDelete('cascade');

            $table->integer('sort_order')->default(0);
            $table->string("sku")->nullable();
            $table->string('barcode')->nullable();
            $table->tinyInteger("type")->default(1)->comment("1=>physical , 2=>digital , 3=>service");

            $table->integer("stock_quantity")->default(0);
            $table->integer('low_stock_threshold')->default(5);

            $table->boolean('requires_shipping')->default(true);
            $table->boolean('is_featured')->default(0);


            /*** tAX && DISCOUNT && PRICE ***/
            $table->boolean("is_taxable")->default(0);
            $table->tinyInteger("tax_type")->default(1)->comment("1=>amount , 2=>percentage");
            $table->decimal("tax_amount", 10, 2)->default(0);
            $table->decimal("discount", 10, 2)->default(0);
            $table->decimal("cost_price", 10, 2)->default(0); // this is the cost of the product
            $table->decimal("selling_price", 10, 2)->default(0); // this is the price of the product before discount and tax
            $table->decimal("total_price", 10, 2)->default(0); // this is the price of the product after discount and tax


            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create("product_translations", function (Blueprint $table) {
            $table->id();
            $table->string("locale")->index();
            $table->string("name");
            $table->longText("description")->nullable();
            $table->text("short_description")->nullable();
            $table->unique(["product_id", "locale"]);
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
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
