<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Test;
use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Repositories\TestRepository;
use App\Repositories\TestQuestionsRepository;
use App\Repositories\QuestionOptionsRepository;
use App\Providers\Form;

class AdminTestController extends Controller
{
	 /**
     * The task repository instance.
     *
     * @var TestOptionRepository
     */
    protected $test_options;
	
    /**
     * Create a new controller instance.
     *
	 * @param  TestQuestionsRepository $test_questions
	 * @param  QuestionOptionsRepository $question_options
     * @return void
     */
    public function __construct(TestQuestionsRepository $test_questions, QuestionOptionsRepository $question_options)
    {
        $this->middleware('auth');
		
        $this->test_questions = $test_questions;
		
		$this->question_options = $question_options;
    }	
	
	/**
	* Create a new test.
	*
	* @param  Request  $request
	* @return Response
	*/
	public function test_create(Request $request)
	{
		$request->user()->tests()->create([
			'title' => $request->title,	
		]);

		return redirect('/admin');
	}
		
	/**
	* Edit test.
	*
	* @param  Test $test
	* @param  TestQuestionsRepository $test_questions
	* @param  QuestionOptionsRepository $question_options
	* @return Response
	*/
	public function edit_test(Test $test, Request $request)
	{
		return view('admin.tests.edit', [
			'test' => $test,		
			'test_questions' => $this->test_questions->forTest($test)->keyBy('id')->all(),/*
			'question_options' => $this->question_options->forTest($test),*/
			'navbar_style' => 'navbar-inverse'
		]);
	}
	
	/**
	* Add Option
	*
	* @param  Test $test
	* @param  TestQuestionsRepository $test_questions
	* @param  Request  $request
	* @return Response
	*/
	public function add_question(Test $test, Request $request)
	{		
		$this->validate($request, [
			'title' => 'required|max:100',
		]); 
		
	 	$test->test_questions()->create([
			'title' => $request->title,
			'type' => $request->type,
		]);
		
		return view('admin.tests.edit', [
			'test' => $test,
			'test_questions' => $this->test_questions->forTest($test)->keyBy('id')->all(),/*		
			'question_options' => $this->question_options->forTest($test),*/
			'navbar_style' => 'navbar-inverse'
		]);
	}
	
		
	/**
	* Edit Questions
	*
	* @param  Test $test
	* @param  TestQuestionsRepository $test_questions
	* @param  Request  $request
	* @return Response
	*/
	public function edit_questions(Test $test, Request $request) {				
				
		/* Edit Questions */
		
		$questions = $request->questions;
	  
		if (!empty($questions)) {
			foreach ($questions as $key => $question) {	
			
				$test->test_questions()
							->where('id', $key)
							->update([
								'title' => $question['title'],	
								'type' => $question['type'],								
							]); 
			}
		}
		
		if (!empty($request->questions_to_delete)) {
			$questions_to_delete_object = $request->questions_to_delete;
		
			$brackets = array("[","]");
			$questions_to_delete_string = str_replace($brackets, "", $questions_to_delete_object[0]);

			$questions_to_delete = explode(",", $questions_to_delete_string);
			
			\DB::table('test_questions')->whereIn('id', $questions_to_delete)->delete();
		}
		
		/* Edit Options */
		
		if (!empty($request->options_to_delete)) {
			$options_to_delete_object = $request->options_to_delete;
		
			$brackets = array("[","]");
			$options_to_delete_string = str_replace($brackets, "", $options_to_delete_object[0]);

			$options_to_delete = explode(",", $options_to_delete_string);
			
			\DB::table('question_options')->whereIn('id', $options_to_delete)->delete();
		}
		
		$options = $request->options;
	  
		if (!empty($options)) {
			foreach ($options as $key => $option) {	
			
				if (!empty($option['title'])) {
					if (!empty($option['new_option'])) {			
						$test->question_options()->create([
							'title' => $option['title'],				
							'question_id' => intval($option['question_id'])
						]); 
					} else {							
						$test->question_options()
							->where('id', $key)
							->update([
							'title' => $option['title'],				
						]); 
					}
				}
			}			
		}
		
		$correct_answers = $request->correct_answers; 
		
		if (!empty($correct_answers)) {
			foreach ($correct_answers as $key => $correct_answer) {	
			
				if (!empty($correct_answer) && $correct_answer[0] != '?') {							
						$test->test_questions()
							->where('id', $key)
							->update([
							'correct_answers' => json_encode($correct_answer),				
						]); 
					
				}
			}			
		}
		 
		return redirect()->back();
	}
	
	/**
	* Show JSON of questions and options for the test for Angular JS
	*
	* @param  Test $test
	* @param  Request  $request
	* @return Response
	*/	
	public function test_crud_json(Test $test)
	{  				
		/* Get questions for the test */
		
		$questions = $this->test_questions->forTest($test);
		
		if (!empty($questions)) {
			$response_questions = $questions->groupBy('id');		
		}		
			
		/* Get question options for the test */
		
		$options = $this->question_options->forTest($test);
		
		if (!empty($options)) {
			$response_options = $options->groupBy('question_id');				 
			
			$last_option = \DB::table('question_options')->orderBy('id', 'desc')->first();
			
			if (!empty($last_option)) {					
				$last_option_id = $last_option->id;
			}
		}
		
		$collection = array('questions' => $response_questions, 'options' => $response_options, 'lastOptionId' => $last_option_id);
		// dd($response_questions);
		 
	 //$response_questions->put$response_options);
		
		return response()->json($collection);
		
		/*if (!empty($response_options) && !empty($last_option_id)) {
			//$response_options->put('lastOptionId', $last_option_id);
			
			return response()->json($response_options);
		} else {				
			return null;
		}*/
	}
}

