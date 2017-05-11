var app = angular.module("myapp",[]);  
 app.controller("register", function($scope, $http){  
      $scope.insertData = function(){  
           $http.post(  
                "../Model/register.php",  
                {'username':$scope.username, 'email':$scope.email, 'password':$scope.password}  
           ).success(function(data){  
                alert(data);  
                $scope.username = null;  
                $scope.email = null;
		$scope.password = null;  
           });  
      }  
 });  

