(function () {
    'use strict';

    angular
        .module('app')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$log','$http','$location', 'AuthenticationService', 'FlashService'];
    function LoginController($location,$log,$http, AuthenticationService, FlashService) {
        var vm = this;

        vm.login = login;

        (function initController() {
            // reset login status
            AuthenticationService.ClearCredentials();

            function login() {
              $http({
                method: 'GET',
                url: './php/request.php'

              })
              .then(function successCallback(response){
                $scope.username = response
                console.log("ola")
              }, function errorCallback(response){
                  $log.error(response)
              });
            };
          /*  AuthenticationService.Login(vm.data, vm.password, function (response) {
                if (response.success) {
                    AuthenticationService.SetCredentials(vm.username, vm.password);
                    $location.path('/');
                } else {
                    FlashService.Error(response.message);
                    vm.dataLoading = false;
                }
          */
        });
      };
});
