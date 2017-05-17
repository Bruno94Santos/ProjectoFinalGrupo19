'use strict';

var app = angular.module("myapp",['ngRoute']);

app.config(function($routeProvider, $locationProvider){
	$routeProvider
		.when('/',{
			templateUrl: 'View/home.html',
			controller: 'home'
		})
		.when('/login', {
			templateUrl: 'View/login.html',
			controller: 'login'
		})
		.when('/register', {
			templateUrl: 'View/register.html',
			controller: 'register'
		})
		.when('/concert', {
			templateUrl: 'View/concert.html',
			controller: 'concert'
		})
		.when('/dashboard', {
			templateUrl: 'View/dashboard.html',
			controller: 'dashboard'
		});
	$locationProvider.html5Mode(true);
});
