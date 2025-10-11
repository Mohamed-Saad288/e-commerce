<?php

namespace App\Modules\Base\Traits;

use Illuminate\Database\Schema\Blueprint;

trait OrganizationMigrationTrait
{
    public function addOrganizationFields(Blueprint $table): void
    {

        $table->foreignId('organization_id')->nullable()->constrained('organizations')->onDelete('set null');
        $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
    }
}
