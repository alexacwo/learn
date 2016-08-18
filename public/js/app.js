
var app = angular.module('angularjs-starter', [])
        .constant('API_URL', 'http://localhost/step/laravel/learn/public/admin/test_options_json/');

app.controller('MainCtrl', function($scope, $http, API_URL ) {
 
 $scope.init = function(apiTestId)
  {
    $scope.apiTestId = apiTestId; 
	console.log($scope.apiTestId);
  
    $http.get(API_URL +  $scope.apiTestId)
		.success(function(response) {
		
		 
			$scope.angularOptionsArray = response;	
			 
			 
			
			$scope.angularOptionsToDelete = [];
			
			
			if (response) {
				$lastOptionId = $scope.angularOptionsArray[Object.keys($scope.angularOptionsArray)[Object.keys($scope.angularOptionsArray).length - 1]]; 
				$scope.angularOptionsArray[Object.keys($scope.angularOptionsArray)[Object.keys($scope.angularOptionsArray).length - 1]];
				delete $scope.angularOptionsArray.lastId;	
			} else {
				
				var $lastOptionId = 0;
				$scope.angularOptionsArray = new Array();
			}
			console.log($scope.angularOptionsArray); 
			 
			
			$scope.addNewOption = function($event, $questionId) {
				
				 
			
				$event.preventDefault();				
				
				if ('undefined' === typeof $scope.angularOptionsArray[$questionId]) {
					
			console.log(1); 
					$scope.angularOptionsArray[$questionId] = new Array(); 
					
					var newOption = {
						id: $lastOptionId + 1,
						question_id: $questionId,
						newOption: true
					};
					
					$scope.angularOptionsArray[$questionId].push(newOption);
					
					$lastOptionId++;
					
				} else if ($scope.angularOptionsArray[$questionId].length < 8) {
					 console.log(2); 
					
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
				//$scope.angOptions[$questionId].splice($optionId);
			};	
   
	});	

  };
}); 