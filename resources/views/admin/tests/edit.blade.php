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
							<i class="fa fa-plus"></i> Add Question
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
							
						<form action="{{ url('/admin/edit_questions/'.$test->id) }}" method="POST" class="form-horizontal">

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
									<th class="col-sm-1">Question type</th>
									<th class="col-sm-5">Options</th>
									<th class="col-sm-1">Choose the correct answer</th>
									<th class="col-sm-1">Remove question</th>
								</thead>
									
								<tbody>
									<tr ng-repeat="(i, angularQuestion) in angularQuestionsArray">
										<td class="table-text col-sm-1">								
											@{{ i*1 }}
										</td> 
										<td class="table-text col-sm-1">
											@{{ angularQuestion[0].id }}
										</td> 
										<td class="table-text col-sm-2">								
											<input type="text" name="questions[@{{angularQuestion[0].id}}][title]" class="form-control" value="@{{ angularQuestion[0].title }}">
										</td>
										<td class="table-text question-type col-sm-2">
											<select name="questions[@{{angularQuestion[0].id}}][type]" class="form-control">
												<option ng-selected="angularQuestion[0].type == 'checkbox'" value="checkbox">Checkboxes</option>
												<option ng-selected="angularQuestion[0].type == 'radio'" value="radio">Radio buttons</option>
												<option ng-selected="angularQuestion[0].type == 'textarea'" value="textarea">Textarea</option>
											</select>	
										</td>									
										<td class="table-text col-sm-5">	
										
											<div class="form-group" ng-show="showOptions ('angularQuestion[0].type')">
												
												<fieldset data-ng-repeat="angularOption in angularOptionsArray[angularQuestion[0].id]" style="margin-bottom:10px;">
													<div class="col-sm-9">
														<input type="text" name="options[@{{ angularOption.id }}][title]" class="form-control" value="@{{ angularOption.title}}">
														<input type="hidden" name="options[@{{ angularOption.id }}][question_id]" value="@{{ angularQuestion[0].id }}">							
														<input type="hidden" name="options[@{{ angularOption.id }}][new_option]" value="@{{ angularOption.newOption }}">	
													</div>
													<div class="col-sm-3">
														<button ng-click="removeOption($event, angularQuestion[0].id, angularOption.id)" class="btn btn-warning">X</button> 
													</div>
													<br>
															
												</fieldset>	
												
												<div class="col-sm-9">												
													<button class="btn btn-info" ng-click="addNewOption($event, angularQuestion[0].id)">
														Add OPTIONS
													</button>
												</div>		
													
											</div> 

										</td>	
										<td class="table-text col-sm-1">
										 
											 <select
												class="correct-answer"
												name="correct_answers[@{{angularQuestion[0].id}}][]"
												ng-model="angularCorrectAnswersArray[angularQuestion[0].id]" 
												ng-options="angularOption.title for angularOption in angularOptionsArray[angularQuestion[0].id] track by angularOption.id"
												ng-show="showOptions ('@{{ angularQuestion[0].type }}')"	
												ng-if="angularQuestion[0].type == 'checkbox'" multiple
											>
											</select>
																					 
											 <select
												class="correct-answer"
												name="correct_answers[@{{angularQuestion[0].id}}]"
												ng-model="angularCorrectAnswersArray[angularQuestion[0].id]" 
												ng-options="angularOption.title for angularOption in angularOptionsArray[angularQuestion[0].id] track by angularOption.id"
												ng-show="showOptions ('@{{ angularQuestion[0].type }}')"	
												ng-if="angularQuestion[0].type == 'radio'"
											>
											</select>
										
										</td>
										<td class="table-text col-sm-1">	
											<button ng-click="removeQuestion($event, angularQuestion[0].id)" class="btn btn-danger">X</button> 
										</td> 
									</tr>
									
								</tbody>
							</table>

							<input type="hidden" name="options_to_delete[]" value="@{{ angularOptionsToDelete }}">
							<input type="hidden" name="questions_to_delete[]" value="@{{ angularQuestionsToDelete }}">
													
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