var app = angular.module("myapp",[]);  
 app.controller("login",['$scope', function($scope, $http, $window){
	 $scope.insertData = function(){ 
		$http.post("../Model/login.php",{'username' : $scope.username, 'password' : $scope.password})
		.success(function(data){
			alert(data);
			$http.get("../Model/dashboard.php", {'username':$scope.username, 'email':$scope.email})
                	.success(function(data){
				$window.location.href = '../View/dashboard.html';
			});
    		});
	}
 }]);  

