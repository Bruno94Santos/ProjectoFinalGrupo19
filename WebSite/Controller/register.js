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
					$location.url("../View/dashboard");
				});
		}
		//$scope.username = null;  
		//$scope.email = null;
		//$scope.password = null;  
	});  
}  
 });

/**********************SIDE BAR / MENU */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").marginLeft = "0";
    document.body.style.backgroundColor = "white";
}