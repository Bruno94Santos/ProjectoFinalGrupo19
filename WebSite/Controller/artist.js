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
