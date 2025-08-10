<?php

namespace App\Modules\Base\Database\Migrations;
use App\Modules\Base\Traits\MigrationTrait;
use Illuminate\Database\Migrations\Migration;


abstract class BaseMigration extends Migration
{
    use MigrationTrait;
}
