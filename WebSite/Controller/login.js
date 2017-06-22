var app = angular.module("myapp",[]);  
 app.controller("login",['$scope', function($scope, $http, $window){
	 $scope.insertData = function(){ 
		$http.get("../Model/Login.php")
		.sucess(function(username, password){
			alert("sucesso");       
			$scope.username = username;
			$scope.password = password;
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