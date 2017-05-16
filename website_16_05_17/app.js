'use strict';

var app = angular.module("myapp",['ngRoute']);

app.config(function($routeProvider){
	$routeProvider
		.when('/View',{
			templateUrl: 'View/home.html',
			controller: 'HomeController'			
		})
		.when('/View', {
			templateUrl: 'View/login.html',
			controller: 'HomeController'
		})
		.when('/View', {
			templateUrl: 'View/register.html',
			controller: 'register'
		})
		.when('/View/:username', {
			templateUrl: 'View/dashboard.html',
			controller: 'dashboard'
		});
		


});
