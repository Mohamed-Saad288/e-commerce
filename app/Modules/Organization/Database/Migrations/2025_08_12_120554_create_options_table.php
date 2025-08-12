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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $this->addOrganizationFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create("option_translations", function (Blueprint $table) {
            $table->id();
            $table->string("locale")->index();
            $table->string("name");
            $table->unique(["option_id", "locale"]);
            $table->foreignId("option_id")->constrained()->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
