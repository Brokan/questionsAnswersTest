<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Questions controller.
 */
class QuestionsController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
       
    }
    
    /**
     * Get list of questions results.
     * @param \App\Http\Controllers\Api\Request $request
     * @return type
     */
    public function getResults(Request $request) {
        $results = (new \App\Libraries\QuestionsReport\QuestionResults)->getQuestionsResults();
        return response()->json($results);
    }
}
