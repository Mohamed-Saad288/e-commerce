<?php

namespace App\Modules\Base\Database\Migrations;
use App\Modules\Base\Traits\MigrationAddedByTrait;
use App\Modules\Base\Traits\MigrationTrait;
use App\Modules\Base\Traits\OrganizationMigrationTrait;
use Illuminate\Database\Migrations\Migration;


abstract class BaseMigration extends Migration
{
    use MigrationTrait,OrganizationMigrationTrait,MigrationAddedByTrait;
}
