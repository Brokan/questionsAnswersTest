<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class AnswerWord extends Model
{
    
    /**
     * Model table name.
     * @var string 
     */
    protected $table = 'answers_words';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'answer_id',
        'word',
        'in_answer_count',
    ];
    
    /**
     * Get the answer that owns the word.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
