<?php

use App\Modules\Base\Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string("slug")->nullable();
            $table->tinyInteger("type")->default(1)->comment("1=>limit , 2=>boolean , 3=>text");
            $this->addAddedByFields($table);
            $this->addGeneralFields($table);
        });
        Schema::create("feature_translations", function (Blueprint $table) {
            $table->id();
            $table->string("locale")->index();
            $table->string("name");
            $table->text("description")->nullable();
            $table->unique(["feature_id", "locale"]);
            $table->foreignId("feature_id")->constrained()->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
