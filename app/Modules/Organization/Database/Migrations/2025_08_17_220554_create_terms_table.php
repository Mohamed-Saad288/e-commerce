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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create('term_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->longText('description')->nullable();
            $table->unique(['term_id', 'locale']);
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
