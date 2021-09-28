<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Questions\Question;

class QuestionSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = \Faker\Factory::create();

        echo 'Start' . PHP_EOL;
        //Save question with answers with type of int
        for ($n = 0; $n < 9; $n++) {
            Question::factory()->count(1)->create([
                'question' => $faker->text(200),
                'type' => Question::$typeInt,
                'rules' => json_encode([
                    'MinInt' => 0,
                    'MaxInt' => 5,
                ]),
            ])->each(function ($question) use ($faker, $n) {
                echo 'Question ' . $n . '; Start generate answers' . PHP_EOL;
                for ($i = 0; $i < 100000; $i++) {
                    $answerSaver = $question->getAnswerSaver();
                    $answerSaver->save($faker->biasedNumberBetween(0, 5));
                }
                //$question->answer()->saveMany(factory(\Database\Factories\AnswerIntFactory::class, 100000)->create());
            });
        }
        echo 'Answers text' . PHP_EOL;
        //Save question with answers with type of text
        Question::factory()->count(1)->create([
            'question' => $faker->text(200),
            'type' => Question::$typeText,
            'rules' => json_encode([
                'TextMaxLength' => 200,
                'TextMinLength' => 3,
            ]),
        ])->each(function ($question) use ($faker) {
            echo 'Start generate answers' . PHP_EOL;
            for ($i = 0; $i < 100000; $i++) {
                $answerSaver = $question->getAnswerSaver();
                $answerSaver->save($faker->text(100));
            }
            //$question->answer()->saveMany(factory(\Database\Factories\AnswerIntFactory::class, 100000)->create());
        });
    }

}
