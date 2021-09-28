<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $question
 * @property string $type Int|Text
 * @property string $rules JSON
 */
class Question extends Model {

    use HasFactory;

    /**
     * Type of question answer.
     * @var string 
     */
    public static $typeInt = 'Int';

    /**
     * Type of question answer.
     * @var string 
     */
    public static $typeText = 'Text';

    /**
     * Model table name.
     * @var string 
     */
    protected $table = 'questions';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'question',
        'type',
        'rules',
    ];

    /**
     * Get answer class.
     * @return \App\Models\Questions\AnswerAbstract
     * @throws \Exception
     */
    public function getAnswerSaver() {
        $answerClass = '\\App\\Libraries\\AnswerSaver\\Answer' . $this->type;

        //Check is insurance class exist.
        if (!class_exists($answerClass)) {
            //Create insurance class.
            throw new \Exception('Answer class "Answer' . $this->type . '" not found', \App\Exceptions\ExceptionsCodes::ANSWER_CLASS_NOT_FOUND);
        }
        return new $answerClass($this);
    }

    /**
     * Get the answers of questions.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
