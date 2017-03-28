(function () {
    'use strict';

    angular
        .module('app')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['UserService', '$rootScope','$scope','$http'];
    function HomeController(UserService, $rootScope, $scope, $http) {
        var vm = this;

        vm.user = null;
        vm.allUsers = [];
        vm.deleteUser = deleteUser;

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
          .then(funtion(d))
          {console.log(d)};
        }
        $scope.filesChanged = function(elm){
          $scope.files = elm.files
          $scope.$apply();
        }
    }
    //add file
    //$scope.add = function (){
      //var f = document.getElementById('file').files[0], r = new FileReader();
      //r.onloadend = function(e){
        //var data = e.target.result;
      //}
      //r.readAsArrayBuffer(f);
    //}


})();
