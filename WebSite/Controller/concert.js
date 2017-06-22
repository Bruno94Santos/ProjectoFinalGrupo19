var app = angular.module("myapp",[]);
app.controller("concert", function($scope, $http){
    $scope.page = 1;
    $http.get('../Model/concert.php', {'page': $scope.page})
        .success(function(data){
	    alert(data);
            $scope.concerts = data;
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



