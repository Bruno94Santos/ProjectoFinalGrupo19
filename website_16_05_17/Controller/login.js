var app = angular.module("myapp",[]);  
 app.controller("login", function($scope, $http){
	 $scope.insertData = function(){ 
		$http.get("../Model/Login.php")
		.sucess(function(result){
			alert("sucesso");       
			$scope.username = result;
			$scope.password = result;
    		});
	}
 });  

