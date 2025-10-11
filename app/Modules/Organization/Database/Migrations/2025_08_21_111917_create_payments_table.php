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
            $table->tinyInteger('status')->default(1)
                ->comment('1=>pending , 2=>completed , 3=>failed , 4=>refunded');

            $table->decimal('amount', 10, 2)->default(0);
            $table->tinyInteger('method')->default(1)->comment(
                '1=>cash_on_delivery , 2=>card , 3=> wallet , 4=>bank_transfer , 5=>paypal'
            );
            $table->tinyInteger('gateway')->default(1)->comment('1=>stripe , 2=>fawry , 3=>paymob , 4=>paypal');
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
