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
		
			<form action="{{ url('/test_result_create/') }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}
			 
				@for ($i = 0; $i < count($test_questions); $i++)

					<br><strong>QUESTION #{{ $i+1 }}:</strong>
					<br><br>{{ $test_questions[$i]->title }}
					
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
							
					<hr style="width:100%;">
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