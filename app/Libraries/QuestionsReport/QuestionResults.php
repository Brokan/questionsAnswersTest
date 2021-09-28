<?php

namespace App\Libraries\QuestionsReport;

use DB;
use App\Models\Questions\Question;
use App\Models\Questions\Answer;
use Illuminate\Database\Eloquent\Collection;
use App\Libraries\QuestionsReport\Traits\QuestionReportIntTrait;
use App\Libraries\QuestionsReport\Traits\QuestionReportTextTrait;
/**
 * Class to work with answer words.
 */
class QuestionResults {

    use QuestionReportIntTrait, QuestionReportTextTrait;
    
    /**
     * Count of top words per question.
     * @var type 
     */
    private $wordsTop = 100;

    /**
     * List of questions IDs for report.
     * @var array 
     */
    private $questionIDs = [];

    /**
     * Questions answers count.
     * @var array 
     */
    private $answersCounts = [];

    /**
     * Question (Type int) average of answers.
     * @var array 
     */
    private $answersAverage = [];

    /**
     * Question answers count per option.
     * @var array 
     */
    private $answersOptionsCount = [];

    /**
     * Get questions results.
     * @return array
     */
    public function getQuestionsResults(): array {
        $questions = $this->getQuestions();
        //Get questions ID's
        $this->prepareQuestionsIDs($questions);
        $this->prepareCountsAndAverages();

        return $this->getResults($questions);
    }

    /**
     * Get list of questions.
     * @return \stdClass
     */
    private function getQuestions(): Collection {
        return Question::get();
    }

    /**
     * 
     * @param Collection $questions
     * @return void
     */
    private function prepareQuestionsIDs(Collection $questions): void {
        $this->questionIDs = [
            Question::$typeInt => [],
            Question::$typeText => [],
        ];
        foreach ($questions as $question) {
            $this->questionIDs[$question->type][$question->id] = $question->id;
        }
    }

    /**
     * Get count and averages for questions.
     * @return void
     */
    private function prepareCountsAndAverages(): void {
        $this->answersCounts = $this->getAnswersCounts(array_merge($this->questionIDs[Question::$typeInt], $this->questionIDs[Question::$typeText]));
        $this->answersAverage = $this->getAnswersAverage($this->questionIDs[Question::$typeInt]);
        $this->answersOptionsCount = $this->getAnswersOptionsCount($this->questionIDs[Question::$typeInt]);
    }

    /**
     * Get results of report.
     * @param Collection $questions
     * @return array
     */
    private function getResults(Collection $questions): array {
        $return = [];
        //Prepare return
        foreach ($questions as $question) {
            $data = [
                'id' => $question->id,
                'question' => $question->question,
                'created_at' => $question->created_at,
                'answers' => $this->answersCounts[$question->id] ?? 0
            ];
            $method = 'setResults' . $question->type;
            if(method_exists($this, $method)){
                $this->$method($data);
            }
            $return[] = $data;
        }
        return $return;
    }

    /**
     * Get questions answers counts.
     * @param array $questionsIDs
     * @return array
     */
    private function getAnswersCounts(array $questionsIDs): array {
        $rows = Answer::select('question_id', DB::raw('COUNT(1) as acount'))
                ->whereIn('question_id', $questionsIDs)
                ->groupBy('question_id')
                ->get();
        $return = [];
        foreach ($rows as $row) {
            $return[$row->question_id] = $row->acount;
        }
        return $return;
    }

    /**
     * Get Int answers average for question
     * @param array $questionsIDs
     * @return array
     */
    private function getAnswersAverage(array $questionsIDs): array {
        $rows = Answer::select('question_id', DB::raw('AVG(answer_int) as aavg'))
                ->whereIn('question_id', $questionsIDs)
                ->groupBy('question_id')
                ->get();
        $return = [];
        foreach ($rows as $row) {
            $return[$row->question_id] = round($row->aavg, 2);
        }
        return $return;
    }

    /**
     * Get question options answers count.
     * @param array $questionsIDs
     * @return array
     */
    private function getAnswersOptionsCount(array $questionsIDs): array {
        $rows = Answer::select('question_id', 'answer_int', DB::raw('COUNT(1) as acount'))
                ->whereIn('question_id', $questionsIDs)
                ->groupBy('question_id', 'answer_int')
                ->get();
        $return = [];
        foreach ($rows as $row) {
            if(!isset($return[$row->question_id])){
                $return[$row->question_id] = [];
            }
            $return[$row->question_id][$row->answer_int] = $row->acount;
        }
        return $return;
    }

}
