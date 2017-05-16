var app = angular.module("myapp",[]);  
 app.controller("register", function($scope, $http){  
      $scope.insertData = function(){  
           $http.post(  
                "../Model/register.php",  
                {'username':$scope.username, 'email':$scope.email, 'password':$scope.password}  
           ).success(function(data){  
                alert(data); 
		$http.get("../Model/Login.php")
		.sucess(function($scope.username, $scope.password){
			alert("sucesso");       
			//$scope.username = username;
			//$scope.password = password;
			$location.url("http://ec2-35-176-3-50.eu-west-2.compute.amazonaws.com/View/dashboard.html");
		});
		}
                //$scope.username = null;  
                //$scope.email = null;
		//$scope.password = null;  
           });  
      }  
 });  

