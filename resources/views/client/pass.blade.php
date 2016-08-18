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
			 
			@for ($i = 0; $i < count($test_questions); $i++)

				<br><strong>QUESTION #{{ $i+1 }}:</strong>
				<br><br>Title: {{ $test_questions[$i]->title }}
				<br><br>Type: {{ $test_questions[$i]->type }}

				<br><br>Options:
				<br><br>
				{{--*/ $options_array = $question_options->where('question_id', $test_questions[$i]->id) /*--}}
				
				<ul>
				@foreach ($options_array as $question_option)            
					<li> {{ $question_option->title }}</li>
				@endforeach
				</ul>
				
				<hr style="width:100%;">
			@endfor
			 
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection