<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_words', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('answer_id');
            $table->string('word', 255);
            $table->integer('in_answer_count')->default(0);
            //Index
            $table->unique(['answer_id', 'word'], 'answer_word');
            $table->index('in_answer_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers_words', function (Blueprint $table) {
            //
        });
    }
}
