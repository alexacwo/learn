@extends('layouts.app')

@section('navbar')
	<!--<li style="border-right: 1px solid gray;"><strong class="text-primary" style="padding: 15px 15px; float: left; text-transform:uppercase;">CLIENT SIDE </strong></li>-->
	<li style="text-transform:uppercase;  border-right: 1px solid white;"> <a href="{{ url('/admin') }}">Edit Tests</a> </li>
	<li style="border-right: 1px solid white;"><span class="text-muted" style="padding: 15px 15px; float: left; color:white;">Menu2</span></li>
	<li style="border-right: 1px solid white;"><span class="text-muted" style="padding: 15px 15px; float: left; color:white;">Menu3</span></li>
	
	<li><a href="{{ url('/') }}">Go to Client Side</a></li>
@endsection

@section('content')

	<!-- New Test Form -->
	<form action="{{ url('/admin/test_create') }}" method="POST" class="form-horizontal">
		{{ csrf_field() }}
		
		<div class="form-group">
			<div class="col-sm-12">
				<div class="col-sm-3"></div>

				<div class="col-sm-6">
					<label for="test-title" class="col-sm-3 control-label" style="text-align:left;padding-left: 0px;">
						Create Test:
					</label>
				</div>

				<div class="col-sm-3"></div>
			</div>

			<div class="col-sm-12">	
				<div class="col-sm-3"></div>			
				<div class="col-sm-3">
					Title:<br>
					<input type="text" name="title" id="test-title" class="form-control">
				</div>
				<div class="col-sm-3">
					Date:<br>
					<input type="date" name="date" id="test-date" class="form-control">
				</div>
			</div>
			
			<div class="col-sm-12">				
				<div class="col-sm-3"></div>

				<div class="col-sm-6">					
					<br>Introduction text:<br>
					<input type="text" name="intro" id="test-intro" class="form-control">
				</div>

				<div class="col-sm-3"></div>
			</div>
		</div>

		<div class="col-sm-12">	
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-default">
						<i class="fa fa-plus"></i> Add Test
					</button>
				</div>
			</div>
		</div>
		
	</form>
	
	<div class="col-sm-12">
		
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
		
			@if (count($tests) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Current Tests
					</div>

					<div class="panel-body">
						<table class="table table-striped test-table">
						
							<thead>
								<th>Test</th>
								<th>Delete the test</th>
							</thead>
							
							<tbody>
								@foreach ($tests as $test)
									<tr>
									
										<td class="table-text">
											{{ Html::link('/admin/edit/'.$test->id, $test->title)}}
										</td>
										
										<td class="table-text">
											<form action="{{ url('delete_test/'.$test->id) }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" class="btn btn-danger">
													<i class="fa fa-trash"></i> Delete
												</button>
											</form>
										</td>
		 
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
		<div class="col-sm-3">
		</div>
		
	</div>
@endsection