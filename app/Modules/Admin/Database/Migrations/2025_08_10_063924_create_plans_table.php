<?php

use App\Modules\Base\Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends BaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('billing_type')->default(1)->comment('1=>monthly , 2=>yearly');
            $table->integer('duration')->default(0);
            $table->integer('trial_period')->default(0);
            $this->addAddedByFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create('plan_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['plan_id', 'locale']);
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
