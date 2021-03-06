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
		
			<form action="{{ url('/test_result_create/') }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}
			 
				@for ($i = 0; $i < count($test_questions); $i++)
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>QUESTION #{{ $i+1 }}:</strong>
							@if ($test_questions[$i]->type == 'checkbox')	
								(Multiple answers are allowed)	
							@endif
						</div>

						<div class="panel-body">
							{{ $test_questions[$i]->title }}
							
							<p>
								@if ($test_questions[$i]->type == 'radio' || $test_questions[$i]->type == 'checkbox')						
								
									{{--*/ $options_array = $question_options->where('question_id', $test_questions[$i]->id) /*--}}
									
									<br><strong>Options:</strong>
									
									<br>
									@foreach ($options_array as $question_option)    
										<input type="{{	$test_questions[$i]->type }}" name="test_answers[{{$test_questions[$i]->id}}][]" value="{{ $question_option->id }}"> {{ $question_option->title }}<Br>
									@endforeach
								@elseif ($test_questions[$i]->type == 'textarea')
										<br><textarea rows="5" cols="50" name="test_answers[{{$test_questions[$i]->id}}][]"></textarea>
								@endif
							</p>
						</div>
					</div>
				@endfor			
				
				<input type="hidden" name="test_id" value="{{ $test->id }}">
				
				<button type="submit" class="btn btn-primary">
					Submit
				</button>
				
			</form>
			 
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection