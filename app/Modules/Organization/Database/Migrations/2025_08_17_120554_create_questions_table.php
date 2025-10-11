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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer("sort_order")->default(0);
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create('question_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->longText('question')->nullable();
            $table->longText('answer')->nullable();
            $table->unique(['question_id', 'locale']);
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
