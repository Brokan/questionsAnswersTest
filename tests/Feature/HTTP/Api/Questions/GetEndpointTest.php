<?php

namespace Tests\Feature\HTTP\Api\Questions;

use Tests\TestCase;
use App\Models\Questions\Question;

/**
 * Future test for endpoint
 */
class GetEndpointTest extends TestCase
{
    /**
     * Endpoint to test.
     * @var string 
     */
    private $endpoint = '/api/questions';
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccess()
    {
        $questionText = 'Test endpoint';
        //Create test data.
        /**
         * @var Question $question
         */
        $question = Question::create([
            'question' => $questionText,
            'type' => Question::$typeInt,
            'rules' => json_encode([]),
        ]);
        /**
         * @var \App\Libraries\AnswerSaver\AnswerInt $question
         */
        $answerSaver = $question->getAnswerSaver();
        $answer1 = $answerSaver->save(1);
        $answer2 = $answerSaver->save(2);
        $answer3 = $answerSaver->save(3);
        
        //Request.
        $response = $this->get($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonStructure();
        
        $responseArray = json_decode($response->getContent(), true);
        $this->assertIsArray($responseArray);
        //Have atleast one question.
        $this->assertTrue(count($responseArray) >= 1);
        //Need to get prepared question.
        $report = $this->getQuestionReport($question->id, $responseArray);
        
        $this->assertIsArray($report);
        $this->assertArrayHasKey('id', $report);
        $this->assertArrayHasKey('question', $report);
        $this->assertEquals($questionText, $report['question']);
        $this->assertArrayHasKey('created_at', $report);
        $this->assertArrayHasKey('answers', $report);
        $this->assertEquals(3, $report['answers']);
        $this->assertArrayHasKey('average', $report);
        $this->assertEquals(2, $report['average']);
        $this->assertArrayHasKey('answers_by_options', $report);
        $this->assertCount(3, $report['answers_by_options']);
        $this->assertArrayHasKey(1, $report['answers_by_options']);
        $this->assertEquals(1, $report['answers_by_options'][1]);
        $this->assertArrayHasKey(2, $report['answers_by_options']);
        $this->assertEquals(1, $report['answers_by_options'][2]);
        $this->assertArrayHasKey(3, $report['answers_by_options']);
        $this->assertEquals(1, $report['answers_by_options'][3]);
        
        //Tear down test data.
        $answer1->delete();
        $answer2->delete();
        $answer3->delete();
        $question->delete();
    }
    
    /**
     * Get exact question report.
     * @param int $questionId
     * @param array $reports
     * @return array
     */
    private function getQuestionReport(int $questionId, array $reports) : array {
        foreach ($reports as $report){
            if(!empty($report['id']) && $report['id'] == $questionId){
                return $report;
            }
        }
        return [];
    }
}
