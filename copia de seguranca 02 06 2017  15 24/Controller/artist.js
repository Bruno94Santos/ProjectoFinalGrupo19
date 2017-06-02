var app = angular.module("myapp",[]);
app.controller("artist", function($scope, $http){
    $http.post('../Model/artist.php', {'artist_id': 1})
        .success(function(result){
            $scope.profile = result;
        })
        .error(function(err){
        });


    /*$scope.pageMusic = 1;
    $http.get('../Model/artist.php', {'page': $scope.pageMusic})
        .success(function(result){
            $scope.music = result;
        })
        .error(function(err){
        });
    $scope.showMusic = function ( ) {
        $scope.pageMusic += 1;
        $http.get('../Model/artist.php', {'id': $scope.idartist})
            .success(function(result){
                $scope.music = result;
            })
            .error(function(err){
            });

    };*/

});
