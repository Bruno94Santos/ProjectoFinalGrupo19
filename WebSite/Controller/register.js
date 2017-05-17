var app = angular.module("myapp",[]);  
app.controller("register",['$scope', '$http'], function($scope, $http){  
	$scope.insertData = function(){  
		$http.post(  
			"../Model/register.php",  
			{'username':$scope.username, 'email':$scope.email, 'password':$scope.password}  
		).success(function(data){  
			alert(data); 
			$http.get("../Model/Login.php")
				.sucess(function(data){
					alert("sucesso");
					//$scope.username = username;
					//$scope.password = password;
					$location.url("/dashboard");
				});
		}
		//$scope.username = null;  
		//$scope.email = null;
		//$scope.password = null;  
	});  
}  
 });  

