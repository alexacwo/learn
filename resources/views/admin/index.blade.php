<!-- resources/views/tasks.blade.php -->

@extends('layouts.app')

@section('navbar')
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">ADMIN PANEL</strong></li>
	<li><a href="{{ url('/admin/') }}">TESTS (edit)</a></li>
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">MENU 2</strong></li>
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">MENU 3</strong></li>
	<li><a href="{{ url('/') }}">Go to Client Side</a></li>
@endsection

@section('content')

	<!-- New Test Form -->
	<form action="{{ url('/admin/test_create') }}" method="POST" class="form-horizontal">
		{{ csrf_field() }}

		
		<!-- Task Name -->
		<div class="form-group">
			<label for="test-title" class="col-sm-3 control-label">Create Test:</label>

			<div class="col-sm-6">
				<input type="text" name="title" id="test-title" class="form-control">
			</div>
		</div>

		<!-- Add Task Button -->
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<button type="submit" class="btn btn-default">
					<i class="fa fa-plus"></i> Add Test
				</button>
			</div>
		</div>
	</form>
	
    <!-- Current Tasks -->
    @if (count($tests) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped test-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Test</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($tests as $test)
                            <tr>
                                <!-- Test Title -->
                                <td class="table-text">
                                    <div>{{ Html::link('/admin/edit/'.$test->id, $test->title)}}</div>
                                </td>
 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
	
	
@endsection