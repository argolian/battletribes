<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsUserTable');
        $permissionsTable = config('roles.permissionsTable');
        $tableCheck = Schema::connection($connection)->hasTable($table);

        if (! $tableCheck) {
            Schema::connection($connection)->create($table, function (Blueprint $table) use ($permissionsTable) {
                $table->increments('id')->unsigned();
                $table->foreignId('permission_id')->constrained($permissionsTable)->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        $connection = config('roles.connection');
        $table = config('roles.permissionsUserTable');
        Schema::connection($connection)->dropIfExists($table);
    }
}
