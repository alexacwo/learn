var app = angular.module('angularjs-starter', [])
        .constant('API_URL', 'http://localhost/step/laravel/learn/public/admin/test_crud_json/');

app.controller('MainController', function($scope, $http, API_URL ) { 
 
	/* Error Message show/hide */	
	$scope.apiMessage = true;	

	// function to evaluate if a number is even
	$scope.showOptions = function($questionType) {
		if($questionType == 'textarea') {
			return false;
		} else {
			return true;
		}
	};
			
	$scope.init = function(apiTestId)
	{
		$scope.apiTestId = apiTestId; 

		$http
			.get(API_URL +  $scope.apiTestId)
			.then(function successCallback(response) {

				/*console.log(response.data.lastOptionId);
				console.log(response.data.questions);
				console.log(response.data.options);*/
			
				/* Responded with an array of Options object */
				
				if (response.data) {		 

					$scope.angularQuestionsArray = response.data.questions;	
					$scope.angularOptionsArray = response.data.options;	

					$lastOptionId = response.data.lastOptionId;				
					
					/* Retrieving the correct answers for questions and assigning the selected attributes on the Edit test page to the answers ids */
					
					$scope.angularCorrectAnswersArray = [];
					
					for (var i in $scope.angularQuestionsArray){
						
						if ('' !== $scope.angularQuestionsArray[i][0].correct_answers)
						{							
							answers = JSON.parse($scope.angularQuestionsArray[i][0].correct_answers);
								
							if (typeof answers == 'object') {	 							
								$scope.angularCorrectAnswersArray[i] = [];
								answers.forEach(function(answer, k, answers) {						
									$scope.angularCorrectAnswersArray[i].push({'id':answer});
								});
							} else {
								$scope.angularCorrectAnswersArray[i] = {'id':answers};
							}
						}
					}	 
					
				} else {
					var $lastOptionId = 0;
					$scope.angularOptionsArray = new Array();
				}		

				$scope.angularQuestionsToDelete = [];			
				$scope.angularOptionsToDelete = [];			
				
				/////////////////////////////////////////////////////////////
				///////////////////QUESTIONS/////////////////////////////////
				/////////////////////////////////////////////////////////////				
				
				/* Remove particular Question */
				$scope.removeQuestion = function($event, $questionId) {
					$event.preventDefault(); 
				
					$scope.angularQuestionsToDelete.push($questionId);
					
					delete $scope.angularQuestionsArray[$questionId];
				};	
				
				/////////////////////////////////////////////////////////////
				///////////////////OPTIONS///////////////////////////////////
				/////////////////////////////////////////////////////////////
				
				/* Add New Option */
				$scope.addNewOption = function($event, $questionId) {

					$event.preventDefault();				

					if ('undefined' === typeof $scope.angularOptionsArray[$questionId]) $scope.angularOptionsArray[$questionId] = new Array();

					if ($scope.angularOptionsArray[$questionId].length < 8) {
						var newOption = {
							id: $lastOptionId + 1,
							question_id: $questionId,
							newOption: true
						};

						$scope.angularOptionsArray[$questionId].push(newOption);

						$lastOptionId++;
					} else {
						alert('Sorry, no more than 8 options is allowed!');
					} 
				};
				
				/* Remove particular Option */
				$scope.removeOption = function($event, $questionId, $optionId) {
					$event.preventDefault(); 

					$scope.angularOptionsToDelete.push($optionId);

					var data = $scope.angularOptionsArray[$questionId];

					for(var i = 0; i < data.length; i++) {
						if(data[i].id == $optionId) {
							data.splice(i, 1);
							break;
						}
					} 
				};	  				

			}, function errorCallback(response) {
				console.log (response, 'Error occurred!!!');				
				$scope.apiMessage = false;
			});		
			
		  /* jQuery('.correct-answer').prop('multiple', function() {
			$questionType = jQuery( this ).parents('.table-text').siblings('.question-type').html().trim();
			if ($questionType == 'radiobuttons') return false;
		});  */
	};
}); 

app.filter('range', function() {
  return function(input, min, max) {
    min = parseInt(min); //Make string input int
    max = parseInt(max);
    for (var i=min; i<max; i++)
      input.push(i);
    return input;
  };
});