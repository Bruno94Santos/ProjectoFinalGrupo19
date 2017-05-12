var app = angular.module("myapp",[]);
app.controller("concert", function($scope, $http){
    $scope.page = 1;
    $http.get('../Model/concert.php', {'page': $scope.page})
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

    }

});




