<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SpendingDiaryCreateSpendingDiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spending_diarie_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 191);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('spending_diaries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('amount', 18, 4)->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('spending_diarie_categories')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spending_diaries');
        Schema::dropIfExists('spending_diarie_categories');
    }
}
