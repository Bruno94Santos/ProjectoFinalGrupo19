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


