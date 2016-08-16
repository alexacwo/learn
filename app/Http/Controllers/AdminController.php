<?php

namespace App\Http\Controllers;

use App\Test;
use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\TestRepository;
use App\Repositories\TestQuestionsRepository;
use App\Repositories\QuestionOptionsRepository;

class AdminController extends Controller
{
	 /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tests;
	
	 /**
     * The task repository instance.
     *
     * @var TestOptionRepository
     */
    protected $test_options;
	
    /**
     * Create a new controller instance.
     *
	 * @param  TestRepository  $tests
     * @return void
     */
    public function __construct(TestRepository $tests)
    {
        $this->middleware('auth');
		
        $this->tests = $tests;
    }
	
	/**
	 * Display a list of all of the user's task.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('admin.index', [
            'tests' => $this->tests->forUser($request->user()),
			'navbar_style' => 'navbar-inverse'
        ]);
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
	public function edit_test(Test $test, TestQuestionsRepository $test_questions, QuestionOptionsRepository $question_options)
	{
		return view('admin.tests.edit', [
			'test' => $test,
			'test_questions' => $test_questions->forTest($test),
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
	public function add_question(Test $test, Request $request, TestQuestionsRepository $test_questions)
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
			'test_questions' => $test_questions->forTest($test),
			'navbar_style' => 'navbar-inverse'
		]);
	}
}

