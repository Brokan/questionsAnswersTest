<?php

namespace App\Libraries\AnswerSaver;

use App\Models\Questions\Question;
use App\Models\Questions\Answer;
use App\Libraries\AnswerSaver\Traits\AnswerValidateTrait;

/**
 * Abstract class to save answer to question.
 */
abstract class AnswerAbstract {

    use AnswerValidateTrait;
    
    /**
     * Answer question class.
     * @var Question 
     */
    public $question;

    /**
     * Answer to save.
     * @var int|text 
     */
    public $answer;
    
    /**
     * Construct class.
     * @param Question $question
     */
    public function __construct(Question $question) {
        $this->question = $question;
    }

    /**
     * Save the answer
     * @param int|string $answer Question answer.
     * @return \App\Models\Questions\Answer
     */
    abstract function save($answer): Answer;
    
}
