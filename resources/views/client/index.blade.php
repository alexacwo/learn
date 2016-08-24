@extends('layouts.app')

@section('navbar')
	<!--<li style="border-right: 1px solid gray;"><strong class="text-primary" style="padding: 15px 15px; float: left; text-transform:uppercase;">CLIENT SIDE </strong></li>-->
	<li style="text-transform:uppercase;  border-right: 1px solid white;"> <a href="{{ url('/') }}">Tests</a> </li>
	<li style="border-right: 1px solid white;"><span class="text-muted" style="padding: 15px 15px; float: left; color:black;">Menu2</span></li>
	<li style="border-right: 1px solid gray;"><span class="text-muted" style="padding: 15px 15px; float: left; color:black;">Menu3</span></li>
	
	@if (Auth::user()->role == 'admin')
		<li><a href="{{ url('/admin') }}">ADMIN DASHBOARD</a></li>
	@endif
@endsection
					
@section('content')

    <div class="panel-body">
        
		<div class="col-sm-3">
		</div>	
		<div class="col-sm-6">	
			 
			<!-- Current Tasks -->
			@if (count($tests) > 0)
				<strong>A LIST OF TESTS:</strong>
				<br>
						@foreach ($tests as $test)	
						
							<div class="task-box task-box-programmers is-available task-binary_gap diff-1">
								<div class="difficulty">
									<span class="one"><span class="two three">{{ $test->date->format('d.m.Y') }}</span></span>
								</div>
								<div class="main-column">
									<div class="layout-floated">
										<div class="left">
											<h4 class="title">
												<a href="{{ url('/test/'.$test->id) }}">
													{{ $test->title }}
												</a>
											</h4>
										</div>
										<div class="right">
											<a href="{{ url('/test/'.$test->id) }}" class="prog-button js-data-survey blue start-button ga">START</a>
										</div>
									</div>
									<div class="synopsis">
										{{--*/ $questions_count = count(\DB::table('test_questions')->where('test_id', $test->id)->get()) /*--}}
										{{ $test->intro }} <strong>({{ $questions_count }} question(s))</strong>
									</div>
								</div>
							</div>
						@endforeach 
			@endif
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection