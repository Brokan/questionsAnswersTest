<?php

namespace App\Libraries\AnswerSaver;

use App\Models\Questions\Answer;

/**
 * Class to work with Text answers.
 */
class AnswerText extends AnswerAbstract {

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
        $answerModel = $this->saveToDB();
        //Save answer words.
        (new AnswerWords())->save($answerModel->id, $this->answer);
        return $answerModel;
    }

    /**
     * Validate answer.
     * @return bool
     */
    private function validate(): bool {
        $this->validateTextMinLength();
        $this->validateTextMaxLength();
        return true;
    }

    /**
     * Save answer to Database.
     * @return Answer
     */
    private function saveToDB(): Answer {
        return Answer::create([
            'question_id' => $this->question->id,
            'anser_text' => $this->answer,
        ]);
    }

}
