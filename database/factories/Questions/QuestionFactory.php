<?php

namespace Database\Factories\Questions;

use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'question' => $this->faker->text(200),
            'type' => $this->faker->randomElement([Question::$typeInt, Question::$typeText]),
            'rules' => json_encode([
                'MinInt' => 0,
                'MaxInt' => 5,
                'TextMaxLength' => 200,
                'TextMinLength' => 3,
            ]),
        ];
    }

}
