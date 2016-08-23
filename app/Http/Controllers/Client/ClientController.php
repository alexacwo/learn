<?php

namespace App\Http\Controllers\Client;

use App\Test;
use App\TestResult;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TestRepository;
use App\Repositories\TestQuestionsRepository;
use App\Repositories\QuestionOptionsRepository;

class ClientController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
  //  protected $tasks;

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
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
		$tests = Test::all();
		
        return view('client.index', [
            'tests' => $tests
        ]);
    }
			
	/**
	* View test.
	*
	* @param  Test $test
	* @return Response
	*/
	public function pass_test(Test $test)
	{
		return view('client.pass', [
			'test' => $test,		
			'test_questions' => $this->test_questions->forTest($test),
			'question_options' => $this->question_options->forTest($test),
			'navbar_style' => 'navbar-default'
		]);
	}
	
				
	/**
	* Create test result
	*
	* @param  Request  $request
	* @return Response
	*/
	public function create_test_result(Request $request)	
	{		
		$test_result = $request->user()->test_results()->create([
			'test_id' => $request->test_id,	
			'test_answers' => json_encode($request->test_answers),	
		]);
		
		return redirect('/test_result/'.$test_result->id);
	}
	
					
	/**
	* Show test result
	*
	* @param  TestResult $test_result
	* @param  Request  $request
	* @return Response
	*/
	public function show_test_result(TestResult $test_result, Request $request)	
	{			
		$correct_answers_array = collect(\DB::table('test_questions')
						 ->select('id', 'title', 'correct_answers')
						 ->where('test_id', $test_result->test_id)
						 ->get()
						 )->keyBy('id')
						 ->all();		
						 
		$question_options = collect(\DB::table('question_options')
						 ->select('id', 'title')
						 ->where('test_id', $test_result->test_id)
						 ->get()
						 )->keyBy('id')
						 ->all();
						
		return view('client.test_result', [
			'test_result' => $test_result,	
			'question_options' => $question_options,					
			'correct_answers_array' => $correct_answers_array,
			'navbar_style' => 'navbar-default'
		]);
	}
	
	/**
	* Create a new task.
	*
	* @param  Request  $request
	* @return Response
	*/
	/*public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
		]);

		$request->user()->tasks()->create([
			'name' => $request->name,
		]);

		return redirect('/tasks');
	}*/
	
	
	/**
	 * Destroy the given task.
	 *
	 * @param  Request  $request
	 * @param  Task  $task
	 * @return Response
	 */
	/*public function destroy(Request $request, Task $task)
	{
		$this->authorize('destroy', $task);
		
		$task->delete();
		
		return redirect('/tasks');
	}*/
}
