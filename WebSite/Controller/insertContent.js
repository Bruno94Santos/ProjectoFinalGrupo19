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