<?php

namespace App\Libraries\QuestionsReport\Traits;

/**
 * Trait for Int type question report.
 */
trait QuestionReportIntTrait {

    /**
     * Set results of int type question answers.
     * @param array $data (Return)
     * @return void
     */
    private function setResultsInt(array &$data): void {
        $data['average'] = $this->answersAverage[$data['id']] ?? 0;
        $data['answers_by_options'] = $this->answersOptionsCount[$data['id']] ?? 0;
    }

}
