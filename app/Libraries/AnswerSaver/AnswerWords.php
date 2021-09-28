<?php

namespace App\Libraries\AnswerSaver;

use App\Models\Questions\Answer;
use App\Models\Questions\AnswerWord;

/**
 * Class to work with answer words.
 */
class AnswerWords {

    /**
     * Construct.
     */
    public function __construct() {
        
    }

    /**
     * Save words of answer.
     * @param int $answerId
     * @param string $answer
     * @return void
     */
    public function save(int $answerId, string $answer): void {
        $words = $this->parseToWords($answer);

        //Delete previosly saved answer words.
        $this->deleteAnswerWords($answerId);

        //Save new words of answer.
        $toSave = [];
        foreach ($words as $word => $count) {
            $toSave[] = [
                'answer_id' => $answerId,
                'word' => $word,
                'in_answer_count' => $count
            ];
        }
        
        AnswerWord::insert($toSave);
    }

    /**
     * Get unique words.
     * @param string $answer
     * @return array
     */
    private function parseToWords(string $answer): array {
        $list = explode(' ', strtolower($answer));
        $words = [];
        foreach ($list as $word) {
            //Remove all comas, points, quotes and other not word symbols.
            $word = preg_replace("/[^a-zA-Z0-9]+/", "", $word);
            //Validate word.
            if (empty($word)) {
                continue;
            }
            //Add to array.
            if (!isset($words[$word])) {
                $words[$word] = 0;
            }
            $words[$word] ++;
        }
        return $words;
    }

    /**
     * Delete previously saved answer words.
     * @param int $answerId
     * @return void
     */
    private function deleteAnswerWords(int $answerId): void {
        AnswerWord::where('answer_id', $answerId)->delete();
    }

}
