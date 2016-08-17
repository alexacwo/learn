<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Test;
use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\TestRepository;
use App\Repositories\TestQuestionsRepository;
use App\Repositories\QuestionOptionsRepository;
use App\Providers\Form;

class AdminMainController extends Controller
{
	 /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tests;
	
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
}

