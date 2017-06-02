var app = angular.module("myapp",[]);  
 app.controller("register", function($scope, $http, $window, $location){
      $scope.insertData = function(){  
           $http.post(  
                "../Model/register.php",  
                {'username':$scope.username, 'email':$scope.email, 'password':$scope.password}  
           ).success(function(data){
                alert(data); 
                $http.post("../Model/login.php",{'username':$scope.username, 'password':$scope.password})
		.success(function(data){
			alert(data);
                    	$http.get("../Model/dashboard.php", {'username':$scope.username, 'email':$scope.email})
                	.success(function(data){
                    		//alert("sucesso");       
                    		//$scope.username = data;
                    		//$scope.email = data;
                    		//$location.url($scope.username);
                    		$window.location.href = '../View/dashboard.html';
                	});
		})
           });  
      }  
 });  
