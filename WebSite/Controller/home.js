var app = angular.module("myapp",[]);  
 app.controller("home", function($scope, $http){  
      $http.get('../Model/home.php')
	.success(function(result){
		$scope.dados = result;
      })
        .error(function(err){
	})
 });  

