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
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $this->addOrganizationFields($table);
            $table->string("image")->nullable();
            $this->addGeneralFields($table);
        });
        Schema::create("header_translations", function (Blueprint $table) {
            $table->id();
            $table->string("locale")->index();
            $table->string("name")->nullable();
            $table->longText("description")->nullable();
            $table->unique(["header_id", "locale"]);
            $table->foreignId("header_id")->constrained()->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headers');
    }
};
