<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        $permissionsTable = config('roles.permissionsTable');
        $rolesTable = config('roles.rolesTable');
        $tableCheck = Schema::connection($connection)->hasTable($table);

        if (! $tableCheck) {
            Schema::connection($connection)->create($table, function (Blueprint $table) use ($permissionsTable, $rolesTable) {
                $table->increments('id')->unsigned();
                $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
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
        $table = config('roles.permissionsRoleTable');
        Schema::connection($connection)->dropIfExists($table);
    }
}
