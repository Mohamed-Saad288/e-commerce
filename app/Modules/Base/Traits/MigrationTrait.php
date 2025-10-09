<?php

namespace App\Modules\Base\Traits;

use Illuminate\Database\Schema\Blueprint;

trait MigrationTrait
{
    public function addGeneralFields(Blueprint $table): void
    {
        $table->boolean('is_active')->comment('1 = active , 0 = inactive')->default(1);
        $table->softDeletes();
        $table->timestamps();
    }
}
