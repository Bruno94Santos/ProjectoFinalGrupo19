(function () {
    'use strict';

    angular
        .module('app')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['$rootScope','$scope','$http'];
    function HomeController($rootScope, $scope, $http) {
        var vm = this;
		$scope.user.username = "Danilea"

        /*vm.user = null;
        vm.allUsers = [];
        vm.deleteUser = deleteUser;*/

        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
        }

       /* function loadCurrentUser() {
            $http.get()
        }

        function loadAllUsers() {
            UserService.GetAll()
                .then(function (users) {
                    vm.allUsers = users;
                });
        }

        function deleteUser(id) {
            UserService.Delete(id)
            .then(function () {
                loadAllUsers();
            });
        }
        $scope.upload = function () {
          $http.post('upload.ashx',$scope.files,{headers:{'Content-Type':'multipart/form-data'}})
          .success(funtion(d))
          {console.log(d)};
        }
        $scope.filesChanged = function(elm){
          $scope.files = elm.files
          $scope.$apply();
        }

        $scope.openNav = function() {
            console.log("AQUi");
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
            document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
          }*/
          $scope.logout = function() {
              console.log("AQUi");
          }

      /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
        /*$scope.closeNav = function() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").marginLeft = "0";
            document.body.style.backgroundColor = "white";
          }
        }*/
})();
