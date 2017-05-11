var app = angular.module("myapp",[]);  
 app.controller("login", function($scope, $http){
	 $scope.insertData = function(){ 
		$http.get("../Model/Login.php")
		.sucess(function(username, password){
			alert("sucesso");       
			$scope.username = username;
			$scope.password = password;
    		});
	}
 });  

