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
			 JUST SOME PLAIN TEXT FOR THE CLIENT SIDE.
			 <br>Nothing to see yet. 
		</div>	
		<div class="col-sm-3">
		</div>		
		
    </div>
@endsection