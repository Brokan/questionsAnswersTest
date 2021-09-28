<?php

namespace App\Libraries\QuestionsReport\Traits;

use DB;
use App\Models\Questions\Answer;

/**
 * Trait for Text type question report.
 */
trait QuestionReportTextTrait {

    /**
     * Set results of int type question answers.
     * @param array $data (Return)
     * @return void
     */
    private function setResultsText(array &$data): void {
        $data['top_words'] = $this->getQuestionAnswersTopWords($data['id']);
    }
    
    /**
     * Get question answers top words.
     * @param int $questionId
     * @return array
     */
    private function getQuestionAnswersTopWords(int $questionId): array {
        $rows = Answer::select('aw.word', DB::raw('COUNT(1) as acount'))
                ->join('answers_words as aw', 'aw.answer_id', '=', 'answers.id')
                ->where('question_id', $questionId)
                ->groupBy('word')
                ->orderBy(DB::raw('COUNT(1)'), 'DESC')
                ->limit($this->wordsTop)
                ->get();
        $return = [];
        foreach ($rows as $row) {
            $return[$row->word] = $row->acount;
        }
        return $return;
    }

}
