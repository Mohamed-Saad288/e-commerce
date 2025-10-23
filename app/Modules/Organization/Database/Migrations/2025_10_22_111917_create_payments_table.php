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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->tinyInteger('status')->default(1)->comment('1=>pending , 2=>completed , 3=>failed , 4=>refunded');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->json('meta')->nullable();

            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
