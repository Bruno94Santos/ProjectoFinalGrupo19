(function () {
    'use strict';

    angular
        .module('app')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['UserService', '$location', '$rootScope', 'FlashService','$scope'];
    function RegisterController(UserService, $location, $rootScope, FlashService, $scope) {

        var vm = this;

        vm.register = register;
        //$scope.text ='enter email'
        //$scope.word = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;

        $scope.email = {
          text: 'example@example.com'
        };

        function register() {

            vm.dataLoading = true;

            UserService.Create(vm.user)
                .then(function (response) {
                    if (response.success) {
                        FlashService.Success('Registration successful', true);
                        $location.path('/login');
                    } else {
                        FlashService.Error(response.message);
                        vm.dataLoading = false;
                    }
                });
        }
    }
})();
