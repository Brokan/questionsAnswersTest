<?php

namespace App\Exceptions;

/**
 * Values of exceptions codes.
 */
class ExceptionsCodes
{
    /**
     * Answer value is lower than in rule set value.
     * @var int 
     */
    const ANSWER_VALIDATION_MIN_INT = 1000;
    
    /**
     * Answer value is bigger than in rule set value.
     * @var int 
     */
    const ANSWER_VALIDATION_MAX_INT = 1001;
    
    /**
     * Answer length is lower than in rule set value.
     * @var int 
     */
    const ANSWER_VALIDATION_MIN_TEXT_LENGTH = 1002;
    
    /**
     * Answer length is bigger than in rule set value.
     * @var int 
     */
    const ANSWER_VALIDATION_MAX_TEXT_LENGTH = 1003;
    
    /**
     * Answer class not found.
     * @var int 
     */
    const ANSWER_CLASS_NOT_FOUND = 1101;
}
