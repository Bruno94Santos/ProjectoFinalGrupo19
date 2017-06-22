(function () {
    'use strict';

    angular
        .module('app', ['ngRoute', 'ngCookies'])
        .config(config)
        .run(run);

    config.$inject = ['$routeProvider', '$locationProvider'];
    function config($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                controller: 'HomeController',
                templateUrl: 'View/home.view.html',
                controllerAs: 'vm'
            })
            /*.when('/header', {
                controller: 'HeaderController',
                templateUrl: 'header/header.view.html',
                controllerAs: 'vm'
            })*/

            .when('/login', {
                controller: 'LoginController',
                templateUrl: 'View/login.view.html',
                controllerAs: 'vm'
            })

            .when('/register', {
                controller: 'RegisterController',
                templateUrl: 'View/register.view.html',
                controllerAs: 'vm'
            })

            .when('/pageArtist', {
                controller: 'PageArtistController',
                templateUrl: 'View/pageArtist.view.html',
                controllerAs: 'vm'
            })

            .when('/createArtist', {
                controller: 'CreateArtistController',
                templateUrl: 'View/createArtist.view.html',
                controllerAs: 'vm'
            })
			.when('/createEvent', {
                controller: 'CreateEventController',
                templateUrl: 'View/createArtist.view.html',
                controllerAs: 'vm'
            })
			.when('/pageEvent', {
                controller: 'PageEventController',
                templateUrl: 'View/createArtist.view.html',
                controllerAs: 'vm'
            })

            .otherwise({ redirectTo: '/login' });
    }

    run.$inject = ['$rootScope', '$location', '$cookieStore', '$http'];
    function run($rootScope, $location, $cookieStore, $http) {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in and trying to access a restricted page
            var restrictedPage = $.inArray($location.path(), ['/login', '/register']) === -1;
            var loggedIn = $rootScope.globals.currentUser;
            if (restrictedPage && !loggedIn) {
                $location.path('/login');
            }
        });
    }

})();
