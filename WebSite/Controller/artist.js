/**
 * Created by susana on 12/05/2017.
 */
var app = angular.module("myapp",[]);
app.controller("artist", function($scope, $http){
    $http.get('../Model/artist.php', {'artist_id': $scope.idProfile})
        .success(function(result){
            $scope.profile = result;
        })
        .error(function(err){
        });


    $scope.pageMusic = 1;
    $http.get('../Model/artist.php/get_artist', {'page': $scope.pageMusic})
        .success(function(result){
            $scope.music = result;
        })
        .error(function(err){
        });
    $scope.showMusic = function ( ) {
        $scope.pageMusic += 1;
        $http.get('../Model/artist.php/get_media_by_artist', {'page': $scope.pageMusic})
            .success(function(result){
                $scope.music = result;
            })
            .error(function(err){
            });

    };

});
