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