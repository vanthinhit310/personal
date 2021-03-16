<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TodoListCreateTodoListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('owner');
            $table->unsignedBigInteger('assignTo')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->text('reason_missed_deadline')->nullable();
            $table->enum('piority', ['LOW', 'NORMAL', 'HIGH'])->default('NORMAL');
            $table->enum('status', ['COMPLETED', 'NEW', 'IN PROGRESS', 'MISSED DEADLINE'])->default('NEW');
            $table->timestamps();

            $table->foreign('owner')->references('id')->on('members')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('assignTo')->references('id')->on('members')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_lists');
    }
}
