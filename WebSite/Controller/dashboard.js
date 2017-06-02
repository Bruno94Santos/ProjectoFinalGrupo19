var app = angular.module("myapp",[]);
app.controller("dashboard", function( $scope, $http){
     //$scope.page = 1;
     $http.get('../Model/dashboard.php')
     .then(function(output){
	$scope.dados = output;
     });

     $scope.logout = function(){
	$http.get('../Model/logout.php')
	     .then(function(response){
		$window.location.href = '../View/login.html';
	     });
     };
    /*$http.get('../Model/concert.php', {'page': $scope.page})
        .success(function(result){
            $scope.concerts = result;
        })
        .error(function(err){
        });
    $scope.showMore = function ( ) {
        $scope.page += 1;
        $http.get('../Model/concert.php', {'page': $scope.page})
            .success(function(result){
                $scope.concerts = result;
            })
            .error(function(err){
            });

    };
    $scope.pageMusic = 1;
    $http.get('../Model/dashboard.php', {'page': $scope.pageMusic})
        .success(function(result){
            $scope.music = result;
        })
        .error(function(err){
        });
    $scope.showMusic = function ( ) {
        $scope.pageMusic += 1;
        $http.get('../Model/dashboard.php', {'page': $scope.pageMusic})
            .success(function(result){
                $scope.music = result;
            })
            .error(function(err){
            });

    };*/

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