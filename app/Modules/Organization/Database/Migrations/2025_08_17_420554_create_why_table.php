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
        Schema::create('why', function (Blueprint $table) {
            $table->id();
            $table->integer("sort_order")->default(0);
            $this->addOrganizationFields($table);
            $table->string('image')->nullable();
            $this->addGeneralFields($table);
        });
        Schema::create('why_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unique(['why_id', 'locale']);
            $table->foreignId('why_id')->constrained('why')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why');
    }
};
