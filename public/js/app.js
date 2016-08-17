
var app = angular.module('angularjs-starter', [])
        .constant('API_URL', 'http://localhost/laravel/learn/public/admin/test_options_json/1');

app.controller('MainCtrl', function($scope, $http, API_URL ) {
 
    $http.get(API_URL)
		.success(function(response) {
		
			$scope.angularOptionsArray = response;	
			
			$scope.angularOptionsToDelete = [];
			
			$lastOptionId = $scope.angularOptionsArray[Object.keys($scope.angularOptionsArray)[Object.keys($scope.angularOptionsArray).length - 1]]; 
			$scope.angularOptionsArray[Object.keys($scope.angularOptionsArray)[Object.keys($scope.angularOptionsArray).length - 1]];
			delete $scope.angularOptionsArray.lastId;	
			
			$scope.addNewOption = function($event, $questionId) {
				
				$event.preventDefault();				
				
				if ('undefined' === typeof $scope.angularOptionsArray[$questionId]) {
					$scope.angularOptionsArray[$questionId] = [];
				}
					
				if ($scope.angularOptionsArray[$questionId].length < 8) {
					console.log($questionId);
					
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

}); 