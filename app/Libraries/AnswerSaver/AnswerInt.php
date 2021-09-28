<?php

namespace App\Libraries\AnswerSaver;

use App\Models\Questions\Answer;
use App\Libraries\AnswerSaver\AnswerAbstract;

/**
 * Class to work with Int answers.
 */
class AnswerInt extends AnswerAbstract {

    use Traits\AnswerValidateTrait;

    /**
     * Save answer to question.
     * @param type $answer
     * @return \App\Models\Libraries\AnswerSaver\Answer
     */
    public function save($answer): Answer {
        $this->answer = $answer;
        try {
            $this->validate();
        } catch (\Exception $ex) {
            throw new \App\Exceptions\ExceptionAnswerSave($ex->getMessage(), $ex->getCode());
        }
        return $this->saveToDB();
    }

    /**
     * Validate answer.
     * @return bool
     */
    private function validate(): bool {
        $this->validateMinInt();
        $this->validateMaxInt();
        return true;
    }

    /**
     * Save answer to Database.
     * @return Answer
     */
    private function saveToDB(): Answer {
        return Answer::create([
            'question_id' => $this->question->id,
            'answer_int' => $this->answer,
        ]);
    }

}
