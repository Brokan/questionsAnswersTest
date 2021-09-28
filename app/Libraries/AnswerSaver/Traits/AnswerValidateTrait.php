<?php

namespace App\Libraries\AnswerSaver\Traits;

use App\Exceptions\ExceptionsCodes;

/**
 * Answer validations trait.
 */
trait AnswerValidateTrait {

    /**
     * Rules list.
     * @var array 
     */
    private $rules = [];

    /**
     * Get rule values to validate answer.
     * @param string $rule
     * @return boolean|mix
     */
    private function getQuestionRuleValue(string $rule) {
        if (empty($this->rules)) {
            //Get rules in array format.
            $this->rules = json_decode($this->question->rules, true);
        }
        //Check is rule is set.
        if (!isset($this->rules[$rule])) {
            return false;
        }
        return $this->rules[$rule];
    }

    /**
     * Validate answer.
     * @return bool
     * @throws \Exception
     */
    private function validateMinInt(): bool {
        $value = $this->getQuestionRuleValue('MinInt');
        if ($value === false) {
            return true;
        }
        if ((int) $this->answer < (int) $value) {
            throw new \Exception('Answer value is < ' . $value, ExceptionsCodes::ANSWER_VALIDATION_MIN_INT);
        }
        return true;
    }

    /**
     * Validate answer.
     * @return bool
     * @throws \Exception
     */
    private function validateMaxInt(): bool {
        $value = $this->getQuestionRuleValue('MaxInt');
        if ($value === false) {
            return true;
        }
        if ((int) $this->answer > (int) $value) {
            throw new \Exception('Answer value is > ' . $value, ExceptionsCodes::ANSWER_VALIDATION_MAX_INT);
        }
        return true;
    }

    /**
     * Validate answer.
     * @return bool
     * @throws \Exception
     */
    private function validateTextMinLength(): bool {
        $value = $this->getQuestionRuleValue('TextMinLength');
        if ($value === false) {
            return true;
        }
        if (strlen($this->answer) < (int) $value) {
            throw new \Exception('Answer length is < ' . $value, ExceptionsCodes::ANSWER_VALIDATION_MIN_TEXT_LENGTH);
        }
        return true;
    }

    /**
     * Validate answer.
     * @return bool
     * @throws \Exception
     */
    private function validateTextMaxLength(): bool {
        $value = $this->getQuestionRuleValue('TextMaxLength');
        if ($value === false) {
            return true;
        }
        if (strlen($this->answer) > (int) $value) {
            throw new \Exception('Answer length is > ' . $value, ExceptionsCodes::ANSWER_VALIDATION_MAX_TEXT_LENGTH);
        }
        return true;
    }

}
