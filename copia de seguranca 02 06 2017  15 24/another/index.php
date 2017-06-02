<!DOCTYPE html>  
 <!-- index.php !-->  
 <html>  
      <head>  
           <title>Webslesson Tutorial | AngularJS Tutorial with PHP - Insert Data into Mysql Database</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center">AngularJS Tutorial with PHP - Insert Data into Mysql Database</h3>  
                <div ng-app="myapp" ng-controller="usercontroller">  
                     <label>Username</label>  
                     <input type="text" name="username" ng-model="username" class="form-control" />  
                     <br />
		     <label>email</label>  
                     <input type="text" name="email" ng-model="email" class="form-control" />  
                     <br />
		     <label>Password</label>  
                     <input type="password" name="password" ng-model="password" class="form-control" />  
                     <br />
                     <input type="submit" name="btnInsert" class="btn btn-info" ng-click="insertData()" value="ADD"/>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 var app = angular.module("myapp",[]);  
 app.controller("usercontroller", function($scope, $http){  
      $scope.insertData = function(){  
           $http.post(  
                "insert.php",  
                {'username':$scope.username, 'email':$scope.email, 'password':$scope.password}  
           ).success(function(data){  
                alert(data);  
                $scope.username = null;  
                $scope.email = null;
		$scope.password = null;  
           });  
      }  
 });  
 </script>  
