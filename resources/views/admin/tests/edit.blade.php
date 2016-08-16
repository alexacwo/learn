<!-- resources/views/tasks.blade.php -->

@extends('layouts.app')

@section('navbar')
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">ADMIN PANEL</strong></li>
	<li><a href="{{ url('/') }}">Task 1</a></li>
	<li><a href="{{ url('/') }}">Task 2</a></li>
	<li><a href="{{ url('/') }}">Go to Client Side</a></li>
@endsection

@section('content')
 <a href="{{ url('/admin/') }}">TEST LIST</a>
 
	<!-- New Test Form -->
	<form action="{{ url('/admin/edit/'.$test->id) }}" method="POST" class="form-horizontal">
		{{ csrf_field() }}

		
		<!-- Task Name -->
		<div class="form-group">
		
			<div class="col-sm-3">
			</div>
			<div class="col-sm-6">
			
			 TEST ID :<br>
 {{ $test->id }}
 <br><br>
				Add Question:
				
				<br>
				<div class="col-sm-6">
					<label for="test-title">Title:</label>
					<input type="text" name="title" id="test-title" class="form-control">
				</div>
				
				<div class="col-sm-6">
					<label for="test-type">Question type:</label>
					<select name="type" id="test-type" class="form-control">
						<option selected value="checkboxes">Checkboxes</option>
						<option value="radiobuttons">Radio buttons</option>
						<option value="textarea">Textarea</option>
					</select>
				</div>			
			</div>
			
		</div>

		<!-- Add Task Button -->
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<button type="submit" class="btn btn-default">
					<i class="fa fa-plus"></i> Add
				</button>
			</div>
		</div>
	</form>
	
	
	<div class="col-sm-3">
			</div>
			<div class="col-sm-6">

 <br>
 TEST QUESTIONS:<br> 
     <!-- Current Tasks -->
    @if (count($test_questions) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Questions for the test
            </div>

            <div class="panel-body">
                <table class="table table-striped questions-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Question number</th>
						<th>Question id in the DB</th>
                        <th>Question TITLE</th>
						<th>Question type</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
						@for ($i = 0; $i < count($test_questions); $i++)
                            <tr>
                                <td class="table-text">								
									{{ $i+1 }}
                                </td> 
                                <td class="table-text">								
									{{ $test_questions[$i]->id }}
                                </td> 
                                <td class="table-text">								
									{{ $test_questions[$i]->title }}
                                </td>
                                <td class="table-text">								
									{{ $test_questions[$i]->type }}
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    @endif
	
			</div>
	
	<div class="col-sm-3">
			</div>
			
			
@endsection