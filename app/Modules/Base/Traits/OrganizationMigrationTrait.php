<?php

namespace App\Modules\Base\Traits;

use Illuminate\Database\Schema\Blueprint;

trait OrganizationMigrationTrait
{

    public function addOrganizationFields(Blueprint $table): void
    {
        $table->unsignedInteger("organization_id")->nullable();
        $table->foreign("organization_id")->references("id")->on("organizations")->onDelete("set null");
        $table->unsignedInteger("employee_id")->nullable();
        $table->foreign("employee_id")->references("id")->on("employees")->onDelete("set null");
    }
}
