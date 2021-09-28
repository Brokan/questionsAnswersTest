<?php

namespace Tests\Unit\App\Libraries\AnswerSaver\AnswerInt;

use Tests\TestCase;
use App\Models\Questions\Question;
use App\Libraries\AnswerSaver\AnswerInt;

/**
 * Test saving Int answers.
 */
class saveTest extends TestCase {

    /**
     * Test question for tests.
     * @var Question
     */
    private $question;

    /**
     * Test when expect exception.
     * @return void
     */
    public function testFailMinInt(): void {
        $this->setQuestion();
                
        $this->expectException(\App\Exceptions\ExceptionAnswerSave::class);
        $this->expectExceptionCode(\App\Exceptions\ExceptionsCodes::ANSWER_VALIDATION_MIN_INT);
        $answer = (new AnswerInt($this->question))->save(-1);
    }

    /**
     * Test when expect exception.
     * @return void
     */
    public function testFailMaxInt(): void {
        $this->setQuestion();
        
        $this->expectException(\App\Exceptions\ExceptionAnswerSave::class);
        $this->expectExceptionCode(\App\Exceptions\ExceptionsCodes::ANSWER_VALIDATION_MAX_INT);
        $answer = (new AnswerInt($this->question))->save(6);
    }

    /**
     * Test when no min int is set.
     * @return void
     */
    public function testSuccessMinInt(): void {
        $this->setQuestion();
        
        //Change rule.
        $this->question->rules = json_encode([
            'MaxInt' => 5,
        ]);
        $answer = (new AnswerInt($this->question))->save(-1);

        $this->assertNotEmpty($answer->id);
        $this->assertEquals(-1, $answer->answer_int);
        $this->assertNull($answer->anser_text);
    }

    /**
     * Test when no max int is set.
     * @return void
     */
    public function testSuccessMaxInt(): void {
        $this->setQuestion();
        
        //Change rule.
        $this->question->rules = json_encode([
            'MinInt' => 0,
        ]);
        $answer = (new AnswerInt($this->question))->save(6);

        $this->assertNotEmpty($answer->id);
        $this->assertEquals(6, $answer->answer_int);
        $this->assertNull($answer->anser_text);
    }

    /**
     * Test when no max int is set.
     * @return void
     */
    public function testSuccessSave(): void {
        $this->setQuestion();
        
        $answer = (new AnswerInt($this->question))->save(3);

        $this->assertNotEmpty($answer->id);
        $this->assertEquals(3, $answer->answer_int);
        $this->assertNull($answer->anser_text);
    }

    /**
     * Set up tests. In setUp() can't use database.
     * @return void
     */
    protected function setQuestion(): void {
        $this->question = Question::create([
                    'question' => 'Test question',
                    'type' => Question::$typeInt,
                    'rules' => json_encode([
                        'MinInt' => 0,
                        'MaxInt' => 5,
                    ]),
        ]);
    }

    /**
     * Tear down tests.
     * @return void
     */
    protected function tearDown(): void {
        $this->question->delete();
    }

}
