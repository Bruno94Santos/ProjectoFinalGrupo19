var app = angular.module("myapp",[]);
app.controller("insertEvent", function($scope, $http){
    this.myDate = new Date();
    this.isOpen = false;
    $scope.insertData = function(){
        $http.post(
            "../Model/createEvent.php",
            {'event_name':$scope.event_name, 'location':$scope.location, 'description':$scope.description, 'total_seats': $scope.total_seats, 'price': $scope.price}
        ).success(function(data){
            alert(data);
            $scope.event_name = null;
            $scope.location = null;
            $scope.description = null;
            $scope.total_seats = null;
            $scope.price = null;
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


