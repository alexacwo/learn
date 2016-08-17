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
		$this->validate($request, [
			'title' => 'required|max:255',
		]); 
		
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
			'test_questions' => $this->test_questions->forTest($test),
			'question_options' => $this->question_options->forTest($test),
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
			'test_questions' => $this->test_questions->forTest($test),			
			'question_options' => $this->question_options->forTest($test),
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
	public function add_option(Test $test, Request $request)	{		
	
		$options = $request->options;
		
		$options_to_delete_object = $request->options_to_delete;
		
		$brackets = array("[","]");
		$options_to_delete_string = str_replace($brackets, "", $options_to_delete_object[0]);

		$options_to_delete = explode(",", $options_to_delete_string);
		
		//dd($options_to_delete);
		
		\DB::table('question_options')->whereIn('id', $options_to_delete)->delete();
		
		foreach ($options as $key => $option) {	

		 	

			if (!empty($option['new_option'])) {			
				$test->question_options()->create([
					'title' => $option['title'],				
					'question_id' => intval($option['question_id']),
				]); 
			} else {							
				$test->question_options()
					->where('id', $key)
					->update([
					'title' => $option['title'],				
				]); 
			}
		}
		
		return redirect()->back();
		
	/*	return view('admin.tests.edit', [
			'test' => $test, 
			'test_questions' => $this->test_questions->forTest($test),		
			'question_options' => $this->question_options->forTest($test),
			'navbar_style' => 'navbar-inverse'
		]);*/
	}
		
	/**
	* Show JSON of options for the test for Angular JS
	*
	* @param  Test $test
	* @param  Request  $request
	* @return Response
	*/	
	public function test_options_json(Test $test){  
			$response_options = $this->question_options->forTest($test)->groupBy('question_id');
			$last_option_id = \DB::table('question_options')->orderBy('id', 'desc')->first()->id;
			
			$response_options->put('lastOptionId', $last_option_id);
			
		    return response()->json($response_options);
	}
}

