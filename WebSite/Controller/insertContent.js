/**
 * Created by susana on 18/05/2017.
 */
var app = angular.module("myapp",[]);
app.controller("insertContent", function($scope, $http){
    $scope.insertData = function(){
        $http.post(
            "../Model/insertContent.php",
            {'song':$scope.song, 'artist_id':$scope.artist_id, 'description':$scope.description, 'is_song': $scope.is_song}
        ).success(function(data){
            alert(data);
            $scope.song = null;
            $scope.artist_id = null;
            $scope.description = null;
            $scope.total_seats = null;
            $scope.is_song = null;
        });


    };
    $scope.is_song = 1;
});