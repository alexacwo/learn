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
			
		
 <br><br>	<form action="{{ url('/admin/add_option/'.$test->id) }}" method="POST" class="form-horizontal">
		{{ csrf_field() }}
				Add Option:
				<br>
				<div class="col-sm-6">
					<label for="test-title">Title:</label> 
				</div> 		
			</div>
			 

		<!-- Add Task Button -->
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
			</div>
		</div>
		
		<div ng-app="angularjs-starter" ng-controller="MainCtrl">
<fieldset  data-ng-repeat="choice in choices">
 
	  
      <input type="text" ng-model="choice.name" name="options[@{{ choice.id }}]" placeholder="Enter mobile number">
      <button ng-show="$last" ng-click="removeChoice($event)">-</button> 
   </fieldset>
   
   
	  <button ng-click="addNewChoice($event)">Add fields</button> 
	  
			</div>	
			dfsdjf<br><br><br><br><br>
				<button type="submit" class="btn btn-default">
					<i class="fa fa-plus"></i> Add
				</button>
	</form>
	
		
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>		
			<script>
				var app = angular.module('angularjs-starter', []);

				app.controller('MainCtrl', function($scope) {

					$scope.choices = [];

					$scope.addNewChoice = function($event) {
						
  $event.preventDefault();
						var newItemNo = $scope.choices.length+1;
						$scope.choices.push({'id':newItemNo});
					};

					$scope.removeChoice = function($event) {
						
  $event.preventDefault();
						var lastItem = $scope.choices.length-1;
						$scope.choices.splice(lastItem);
					};

				});
			</script>
	<div class="col-sm-3">
			</div>
			<div class="col-sm-6">

 <br>
 OPTIONS:<br> 
     <!-- Current Tasks -->
    @if (count($question_options) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                OPTIONS
            </div>

            <div class="panel-body">
			
                <table class="table table-striped questions-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Option number</th>
						<th>Option id in the DB</th>
                        <th>Option TITLE</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
					
						@for ($j = 0; $j < count($question_options); $j++)
                            <tr>
                                <td class="table-text">								
									{{ $j+1 }}
                                </td> 
                                <td class="table-text">								
									{{ $question_options[$j]->id }}
                                </td> 
                                <td class="table-text">								
									{{ $question_options[$j]->title }}
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
					
{!! Form::open(array('url' => 'foo/bar')) !!}
    {!! Form::label('Your Name') !!}
   AAAAAAAAA <br><br><br><br>{{ Form::bsText('first_name') }}
{!! Form::close() !!}
				{{ dd($request) }}
@endsection