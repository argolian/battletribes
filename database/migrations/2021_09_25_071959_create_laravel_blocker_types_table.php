<?php

use App\Models\BlockedType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelBlockerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $blocked    = new BlockedType();
        $connection = $blocked->getConnection();
        $table      = $blocked->getTableName();
        $tableCheck = Schema::connection($connection->getName())->hasTable($table);

        if (!$tableCheck)
        {
            Schema::create('laravel_blocker_types', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('slug')->unique();
                $table->string('name');
                $table->timestamps();
                $table->softDeletes();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laravel_blocker_types');
    }
}
