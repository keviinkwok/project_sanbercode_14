<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCommentsAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('answer_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments_answers', function (Blueprint $table) {
            $table->dropForeign(['answer_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['answer_id']);
            $table->dropColumn(['user_id']);
        });
    }
}
