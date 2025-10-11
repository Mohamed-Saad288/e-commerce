<?php

namespace App\Modules\Base\Traits;

use Illuminate\Database\Schema\Blueprint;

trait MigrationAddedByTrait
{
    public function addAddedByFields(Blueprint $table): void
    {
        $table->unsignedBigInteger('added_by_id')->nullable();
        $table->foreign('added_by_id')->references('id')->on('admins')->onDelete('set null');
    }
}
