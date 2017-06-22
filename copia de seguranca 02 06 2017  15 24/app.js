'use strict';

console.log("ola");
var app = angular.module("myapp",['ngRoute']);

app.config(function($routeProvider){
	$routeProvider
		.when('/',{
			templateUrl: 'View/dashboard.html',
			controller: 'dashboard'			
		})
		.when('/login', {
			templateUrl: 'View/login.html',
			controller: 'login'
		})
		.when('/register', {
			templateUrl: 'View/register.html',
			controller: 'register'
		})
		.when('/artist', {
			templateUrl: 'View/artist.html',
			controller: 'artist'
		})
		.when('/concert', {
			templateUrl: 'View/concert.html',
			controller: 'concert'
		});

	//$locationProvider.html5Mode({enabled:true, requireBase:false});
});