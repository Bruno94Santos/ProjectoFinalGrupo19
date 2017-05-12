/**
 * Created by susana on 12/05/2017.
 */
var app = angular.module("myapp",[]);
app.controller("dashboard", function($scope, $http){
    $scope.page = 1;
    $http.get('../Model/concerts.php', {'page': $scope.page})
        .success(function(result){
            $scope.concerts = result;
        })
        .error(function(err){
        });
    $scope.showMore = function ( ) {
        $scope.page += 1;
        $http.get('../Model/concerts.php', {'page': $scope.page})
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

    };

});