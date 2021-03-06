<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('status_id');
            $table->integer('store_id');
            $table->boolean('has_power_adapter')->default('false');
            $table->boolean('has_carrying_case')->default('false');
            $table->boolean('has_mouse')->default('false');
            $table->boolean('has_keyboard')->default('false');
            $table->boolean('has_external_hdd')->default('false');
            $table->boolean('has_flash_drive')->default('false');
            $table->boolean('has_printer')->default('false');
            $table->boolean('has_display')->default('false');
            $table->boolean('has_system_discs')->default('false');
            $table->boolean('has_router')->default('false');
            $table->boolean('has_wireless_adapter')->default('false');
            $table->string('workorder');
            $table->string('customer');
            $table->string('phone');
            $table->string('device');
            $table->string('password');
            $table->text('notes');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
