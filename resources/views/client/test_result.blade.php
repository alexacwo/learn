@extends('layouts.app')
@section('navbar')
	<li><strong class="text-primary" style="padding: 15px 15px; float: left; text-transform:uppercase;">CLIENT SIDE</strong></li>
	<li><a href="{{ url('/') }}">Tests</a></li>
	<li><a href="{{ url('/') }}">Reading</a></li>
	<li><a href="{{ url('/') }}">Audio files</a></li>
	@if (Auth::user()->role == 'admin')
		<li><a href="{{ url('/admin') }}">ADMIN DASHBOARD</a></li>
	@endif
@endsection
					
@section('content')

    <div class="panel-body">
        
		<div class="col-sm-3">
		</div>	
		<div class="col-sm-6">
		
		<strong>YOUR RESULTS:</strong><br><br>
		
			@if (!empty($test_result))
				
				@foreach (json_decode($test_result->test_answers) as $question_id => $test_answers) 
					
					<strong>Question # {{ $question_id }}<br></strong>
					
					
					
					@foreach ($test_answers as $answer_id => $value) 
						<br>{{ $value }}
					@endforeach
					
					<br><br>
				@endforeach
			
			@endif
			
		<strong>CORRECT ANSWERS:</strong><br><br>		
				
		@if (!empty($correct_answers))
			
			
			@foreach ($correct_answers as $ca) 
			
					<br>QUESTION # {{	$ca->id	}}
			 		
					{{--*/ $correct_answers_array = json_decode($ca->correct_answers) /*--}}
					
					@if (!empty ($correct_answers_array))						
					
						<br><br>ANSWERS:
						@foreach ($correct_answers_array as $correct_answer) 

							{{ $correct_answer }}

						@endforeach
					@endif
			@endforeach
		@endif
			 
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection