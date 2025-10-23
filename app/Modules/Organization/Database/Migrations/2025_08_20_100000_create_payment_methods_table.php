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
        // Create payment methods table
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // stripe, paypal, etc.
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('required_settings'); // JSON array of required configuration fields
            $table->timestamps();
        });

        // Create payment method translations
        Schema::create('payment_method_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['payment_method_id', 'locale']);
        });

        // Create organization payment methods table
        Schema::create('organization_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('credentials'); // Store payment gateway credentials
            $table->timestamps();

            // Each organization can have a payment method only once
            $table->unique(['organization_id', 'payment_method_id'], 'org_pm_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_payment_methods');
        Schema::dropIfExists('payment_method_translations');
        Schema::dropIfExists('payment_methods');
    }
};
