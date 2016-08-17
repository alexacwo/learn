
var app = angular.module('angularjs-starter', [])
        .constant('API_URL', 'http://localhost/step/laravel/learn/public/admin/test_options_json/1');

app.controller('MainCtrl', function($scope, $http, API_URL ) {

var getEntries = function(){ 
    $http.get(API_URL)
		.success(function(response) {
		
			$scope.angularOptionsArray = response;	
			
			console.log($scope.angularOptionsArray);
			   });	
    };

    getEntries();
	

			
			$scope.angOptions = [];		
			
			$scope.addNewOption = function($event, $questionId) {
				
				console.log($questionId);
				if (typeof $scope.angularOptionsArray[$questionId] === 'undefined' || $scope.angularOptionsArray[$questionId].length == 0) {
					$scope.angularOptionsArray[$questionId] = [];
				}
				
				$event.preventDefault();
				var o = new Object();
				var newItemNo = $scope.angularOptionsArray[$questionId].length + 1;
				$scope.angularOptionsArray.push(o);
			};

			$scope.removeOption = function($event, $questionId, $optionId) {
				$event.preventDefault(); 
				$scope.angOptions[$questionId].splice($optionId);
			};	


}); 