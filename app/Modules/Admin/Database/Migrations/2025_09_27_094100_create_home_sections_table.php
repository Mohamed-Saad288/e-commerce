<?php

use App\Modules\Base\Traits\MigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use MigrationTrait;
    public function up(): void
    {
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId("organization_id")
                ->nullable()
                ->constrained("organizations")
                ->onDelete("set null");

            $table->dateTime("start_date")->nullable();
            $table->dateTime("end_date")->nullable();

            $table->tinyInteger("type")
                ->nullable()
                ->comment("1=>best_seller , 2=>trending , 3=>special_offer , 4=>new_collection , 5=>top_rated , 6=>featured_products , 7=>custom");

            $table->integer("sort_order")->default(0);
            $this->addGeneralFields($table);

            $table->index(["type", "organization_id"]);
        });

        Schema::create("home_section_translations", function (Blueprint $table) {
            $table->id();
            $table->string("locale")->index();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->string("button_text")->nullable();
            $table->unique(["home_section_id", "locale"]);
            $table->foreignId("home_section_id")->constrained()->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
