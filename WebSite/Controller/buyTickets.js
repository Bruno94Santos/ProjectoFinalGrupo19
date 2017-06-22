/**
 * Created by susana on 18/05/2017.
 */

var app = angular.module("myapp",[]);
app.controller("buyTickets", function($scope, $http){
    $scope.insertData = function(){
        $http.post(
            "../Model/buyTickets.php",
            {'name':$scope.name, 'surname':$scope.surname, 'phone':$scope.phone, 'email': $scope.email, 'adress': $scope.adress}
        ).success(function(data){
            alert(data);
            $scope.name = null;
            $scope.surname = null;
            $scope.phone = null;
            $scope.email = null;
            $scope.adress = null;
        });


    };

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