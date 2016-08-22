@extends('layouts.app')

@section('navbar')
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">ADMIN PANEL</strong></li>
	<li><a href="{{ url('/admin/') }}">TESTS (edit)</a></li>
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">MENU 2</strong></li>
	<li><strong class="text-muted" style="padding: 15px 15px; float: left; text-transform:uppercase; color:white;">MENU 3</strong></li>
	<li><a href="{{ url('/') }}">Go to Client Side</a></li>
@endsection

@section('content')

<div  ng-app="angularjs-starter" ng-controller="MainController" ng-init="init({{ $test->id }})">

	<div class="col-sm-12">

		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
		
			<form action="{{ url('/admin/edit/'.$test->id) }}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
			
				<div class="form-group">
					<div class="col-sm-12">
						
						<br><br><strong>TEST ID:</strong> {{ $test->id }}
						
						<br><br><strong>FORM FOR ADDING QUESTION:</strong>
					</div>
					
					<div class="col-sm-6">
						<label for="test-title">Title:</label>
						<input type="text" name="title" id="test-title" class="form-control">				 
					</div>
					<div class="col-sm-6">
						<label for="test-type">Question type:</label>
						<select name="type" id="test-type" class="form-control">
							<option selected value="checkbox">Checkboxes</option>
							<option value="radio">Radio buttons</option>
							<option value="textarea">Textarea</option>
						</select>					
						<br>If there can be multiple options, select 'checkboxes'
						<br>If there can be only one option, select 'radio buttons'
						<br>If the question doesn't provide any choices, so that a user can give a free answer, select 'textarea'
					</div>
				</div>	  
				
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default">
							<i class="fa fa-plus"></i> Add
						</button>
					</div>
				</div>
				
			</form>
			
		</div>
		<div class="col-sm-1">
		</div>
		
	</div>

	<div class="col-sm-12">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">	
		
			<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
			
			<strong>TABLE WITH QUESTIONS FOR THIS TEST (id #{{ $test->id }}):</strong><br><br>
			
			@if (count($test_questions) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Questions for the test
					</div>

					<div class="panel-body">
							
						<form action="{{ url('/admin/add_option/'.$test->id) }}" method="POST" class="form-horizontal">

						{{ csrf_field() }}

							<button type="submit" class="btn btn-primary">
								SAVE TEST
							</button>
							
							<p>
							<div ng-hide="apiMessage" class="alert alert-danger">
								<strong>Sorry, there was some error during proceeding your request. Please refresh the page!</strong>
							</div>
							
							<table class="table table-striped questions-table">

								<thead>
									<th class="col-sm-1">Question number</th>
									<th class="col-sm-1">Question id in the DB</th>
									<th class="col-sm-2">Question TITLE</th>
									<th class="col-sm-2">Question type</th>
									<th class="col-sm-5">Options</th>
									<th class="col-sm-1">Choose the correct answer</th>
								</thead>
									
								<tbody>
									@for ($i = 0; $i < count($test_questions); $i++)
										<tr>
											<td class="table-text col-sm-1">								
												{{ $i+1 }}
											</td> 
											<td class="table-text col-sm-1">								
												{{ $test_questions[$i]->id }}
											</td> 
											<td class="table-text col-sm-2">								
												{{ $test_questions[$i]->title }}
											</td>
											<td class="table-text question-type col-sm-2">								
												{{ $test_questions[$i]->type }}
											</td>									
											<td class="table-text col-sm-5">	
											
												<div class="form-group" ng-show="showOptions ('{{ $test_questions[$i]->type }}')">
													
													<fieldset data-ng-repeat="angularOption in angularOptionsArray[{{ $test_questions[$i]->id }}]" style="margin-bottom:10px;">
														<div class="col-sm-9">
															<input type="text" name="options[@{{ angularOption.id }}][title]" class="form-control" value="@{{ angularOption.title}}">
															<input type="hidden" name="options[@{{ angularOption.id }}][question_id]" value="{{ $test_questions[$i]->id }}">							
															<input type="hidden" name="options[@{{ angularOption.id }}][new_option]" value="@{{ angularOption.newOption }}">	
														</div>
														<div class="col-sm-3">
															<button ng-click="removeOption($event, {{ $test_questions[$i]->id }}, angularOption.id)" class="btn btn-danger">X</button> 
														</div>
														<br>
																
													</fieldset>	
													
													<div class="col-sm-9">												
														<button class="btn btn-info" ng-click="addNewOption($event, {{ $test_questions[$i]->id }})">
															Add OPTIONS
														</button>
													</div>		
														
												</div> 
	
											</td>	
											<td class="table-text col-sm-1">
												 <select
													class="correct-answer"
													name="correct_answers[{{ $test_questions[$i]->id }}][]"
													ng-model="angularCorrectAnswersArray[{{ $test_questions[$i]->id }}]" 
													ng-options="angularOption.title for angularOption in angularOptionsArray[{{ $test_questions[$i]->id }}] track by angularOption.id"
													ng-show="showOptions ('{{ $test_questions[$i]->type }}')"
													
													@if ($test_questions[$i]->type == 'checkbox') 
														multiple
													@endif 
												>
												</select>
												
												 

											</td>
										</tr>
									@endfor
									
									@{{ angularCorrectAnswersArray }}
								</tbody>
							</table>

							<input type="hidden" name="options_to_delete[]" value="@{{ angularOptionsToDelete }}">
													
						</form>
					</div>
				</div>
			@endif

		</div>

		<div class="col-sm-1">
		</div>
	</div>
	 
</div> <!-- end of Angular MainController -->
 
@endsection