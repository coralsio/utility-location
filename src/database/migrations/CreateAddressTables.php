<?php

namespace Corals\Utility\Location\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTables extends Migration
{
    public function up()
    {
        \Schema::create('utility_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            ;
            $table->string('zip')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('properties')->nullable();
            $table->string('slug')->unique()->index();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->string('module')->nullable();
            $table->string('type')->nullable()->index();
            $table->unsignedInteger('parent_id')->nullable()->default(0);

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('utility_locations');
    }
}
