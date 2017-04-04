(function () {
    'use strict';

    angular
        .module('app')
        .controller('HeaderController', HeaderController);

    HeaderController.$inject = ['UserService', '$rootScope','$scope','$http'];
    function HeaderController(UserService, $rootScope, $scope, $http) {
        var vm = this;

        vm.user = null;
        vm.allUsers = [];


        initController();

        function initController() {
            loadCurrentUser();
            loadAllUsers();
        }

        function loadCurrentUser() {
            UserService.GetByUsername($rootScope.globals.currentUser.username)
                .then(function (user) {
                    vm.user = user;
                });
        }
        $scope.selected = [];
        $scope.existType = function (item){
          console.log("aaaaa");
          return $scope.selected.indexOf(item) > -1;
        };
        $scope.Ola = function(){
          console.log("ola");
        };

        /**********************SIDE BAR / MENU */
        function openNav() {
            console.log("AQUi");
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
      }
})();
