<?php

use App\Modules\Base\Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders")->onDelete("cascade");
            $table->foreignId("product_id")->constrained("products")->onDelete("cascade");
            $table->foreignId("product_variant_id")->nullable()->constrained("product_variations")->onDelete("cascade");
            $table->integer("quantity")->default(1);
            $table->decimal("price", 10, 2)->default(0); // this is the price of the product before discount and tax
            $table->decimal("sub_total", 10, 2)->default(0); // this is the price of the product * quantity
            $table->tinyInteger("tax_type")->default(1)->comment("1=>amount , 2=>percentage");
            $table->decimal("tax_amount", 10, 2)->default(0);
            $table->decimal("discount", 10, 2)->default(0);
            $table->decimal("total_amount", 10, 2)->default(
                0
            ); // this is the price of the product after discount and tax
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
