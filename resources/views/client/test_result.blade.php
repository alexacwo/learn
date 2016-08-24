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
				
					{{--*/ $correct_answers = json_decode($correct_answers_array[$question_id]->correct_answers) /*--}}
					 
					@if (is_array($correct_answers))
						@if (empty (array_diff( $correct_answers , $test_answers)) && empty (array_diff( $test_answers , $correct_answers)) && !empty($correct_answers))
							<div class="panel panel-success">
						@else 
							<div class="panel panel-danger">
						@endif						
					@else 
						@if (intval($correct_answers) == intval($test_answers[0]) && !empty($correct_answers))
							<div class="panel panel-success">
						@elseif (empty($correct_answers))
							<div class="panel panel-warning">
						@else
							<div class="panel panel-danger">
						@endif
					@endif
					
					
						<div class="panel-heading">
							<strong>Question # {{ $question_id }}</strong>
						</div>

						<div class="panel-body">
					 
							{{  $correct_answers_array[$question_id]->title }}<br>
							
							<br><strong>Your answer(s):</strong>
							@foreach ($test_answers as $answer_id => $value) 
								
								@if (is_numeric($value))							
									<br>{{ $question_options[$value]->title }}
								@else
									<br>{{ $value }}
								@endif
								
							@endforeach
								
							
							@if (!empty($correct_answers))
									
							<br><br><span style="color:green;"><strong>Correct answer(s):</strong></span>
									@if (is_array($correct_answers))
										@foreach ($correct_answers as $value)
											<br>{{ $question_options[$value]->title }}
										@endforeach
									@else
											<br>{{ $question_options[intval($correct_answers)]->title }}						
									@endif
								@endif
							</div>
						</div>
				@endforeach
			
			@endif
			
	<!--	<strong>CORRECT ANSWERS:</strong><br>	
		
		@if (!empty($correct_answers_array))
			
			@foreach ($correct_answers_array as $ca) 
			
					<br><strong>QUESTION # {{	$ca->id	}}</strong>
			 		
					{{--*/ $correct_answers = json_decode($ca->correct_answers) /*--}}
					
					@if (is_array ($correct_answers))						
					
						<br><br><strong>ANSWERS:</strong>
						@foreach ($correct_answers as $correct_answer) 

							{{ $correct_answer }}

						@endforeach
					@else
						<br><strong>ANSWER:</strong> {{ $correct_answers }}<br>
					@endif
			@endforeach
		@endif -->
			 
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection