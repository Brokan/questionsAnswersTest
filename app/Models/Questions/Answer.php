<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{    
    /**
     * Model table name.
     * @var string 
     */
    protected $table = 'answers';
    
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
        'question_id',
        'answer_int',
        'anser_text',
    ];
    
    /**
     * Get the answer words.
     */
    public function words()
    {
        return $this->hasMany(AnswerWord::class);
    }
    
    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
