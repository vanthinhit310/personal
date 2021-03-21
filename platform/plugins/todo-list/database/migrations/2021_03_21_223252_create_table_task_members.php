<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTaskMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();

            $table->foreign('task_id')->references('id')->on('todo_lists')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('member_id')->references('id')->on('members')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_task_members');
    }
}
