/**
 * Created by susana on 15/03/2017.
 */

/***********CONTROLLER MAIN PAGE*/
var musInApp = angular.module('musInApp', []);

musInApp.controller('musController', function($scope){
    $scope.concert = "Concerto XXX";
    $scope.description = "concerto giru #descriçao";
    $scope.price = "20euros";
});

musInApp.controller('music', function($scope){
    $scope.music = "ficheiro mp3";
    $scope.description = "musicah girah #descriçao";

});

musInApp.controller('video', function($scope){
    $scope.video = "video.wav";
    $scope.description = "descrição do video";
})

musInApp.controller('profile', function($scope){
    $scope.name = 'Maria Cena';
    $scope.place = 'San Fran';
    $scope.mail = 'maria.cena@gmail.com';
    $scope.web = 'lala.com';
    $scope.birthday = '11.June.1995';
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
    document.getElementById("main").style.marginLeft = "0";
    document.body.style.backgroundColor = "white";
}