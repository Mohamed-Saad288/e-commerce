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
        Schema::create('privacy', function (Blueprint $table) {
            $table->id();
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create('privacy_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->longText('description')->nullable();
            $table->unique(['privacy_id', 'locale']);
            $table->foreignId('privacy_id')->constrained('privacy')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy');
        Schema::dropIfExists('privacy_translations');
    }
};
