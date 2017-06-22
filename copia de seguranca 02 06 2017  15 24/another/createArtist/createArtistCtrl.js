(function () {
    'use strict';

    angular
        .module('app')
        .controller('CreateArtistController', CreateArtistController);

    function CreateArtistController ($scope) {

      $scope.toppings = [
        { category: 'music type', name: 'Jazz / Bossa Nova' },
        { category: 'music type', name: 'Hip Hop / Rap' },
        { category: 'music type', name: 'Rock' },
        { category: 'music type', name: 'Metal' },
        { category: 'music type', name: 'Blues' },
        { category: 'music type', name: 'Pop' },
        { category: 'music type', name: 'Classical Music' },
        { category: 'music type', name: 'Electronic Music' },
        { category: 'music type', name: 'Reggae' },
        { category: 'music type', name: 'R&B / Soul' },
        { category: 'music type', name: 'Country Music' },
        { category: 'music type', name: 'Alternative Music' },
        { category: 'music type', name: 'Tradicional / World  Music' }
      ];

      $scope.selected = [];
      $scope.tagsSelected = [];

      $scope.existType = function (item){

        return $scope.selected.indexOf(item) > -1;
      }

      $scope.existTag = function (item){

        return $scope.tagsSelected.indexOf(item) > -1;
      }

      $scope.typeSelection = function(item){

        var idx = $scope.selected.indexOf(item);

        if(idx > -1){
          $scope.selected.splice(idx, 1);
        }
        else{
          $scope.selected.push(item)
        }
      }
      $scope.tagsSelection = function(item){

        var idx = $scope.tagsSelected.indexOf(item);

        if(idx > -1){
          $scope.tagsSelected.splice(idx, 1);
        }
        else{
          $scope.tagsSelected.push(item)
        }
      }
    }
    })();



    //CreateArtistController.$inject = ['$scope','$element'];

    //function CreateArtistController($scope, $element) {
      //$scope.vegetables = ['jazz' ,'Hip Hop / Rap' ,'Rock' ,'Pop' ,'Classical Music', 'Electronic Music', 'Asian Pop','Reggae', 'Indie Pop', 'R&B / Soul', 'Country Music', 'Alternative Music'];
      //$scope.searchTerm;
      //$scope.clearSearchTerm = function() {
      //  $scope.searchTerm = '';
      //};
      // The md-select directive eats keydown events for some quick select
      // logic. Since we have a search input here, we don't need that logic.
      //$element.find('input').on('keydown', function(ev) {
      //    ev.stopPropagation();
      //});
    //};
  //});

    // FUNCAO PARA CHECKALL NA CHECKBOX !!
    //$scope.checkAll = funtion(){
      //if($scope.selectedAll) {
        //angular.forEach($scope.toppings, funtion(item)){
          //idx = $scope.selected.indexOf(item);
          //if(idx >= 0) {
            //return true;
          //}
          //else{
            //$scope.selected.push(item);
          //}
      //}
        //else{
          //$scope.selected = [];
        //}
    //}









      //$scope.checkAll = function(){
        //if($scope.selectedAll) {
          //angular.forEach($scope.toppings, funtion(item)){
            //idx = $scope.selected.indexOf(item);
            //if(idx >= 0 ) {
              //return true;
            //}
            //else{
            //$scope.selected.push(item);
            //}
          //})
        //}
        //else{
          //$scope.selected = [];
        //}
      //})

      //$scope.printSelectedToppings = function printSelectedToppings() {
        //var numberOfToppings = this.selectedToppings.length;

          // If there is more than one topping, we add an 'and'
         // to be gramatically correct. If there are 3+ toppings
        // we also add an oxford comma.
        //if (numberOfToppings > 1) {
          //var needsOxfordComma = numberOfToppings > 2;
          //var lastToppingConjunction = (needsOxfordComma ? ',' : '') + ' and ';
          //var lastTopping = lastToppingConjunction +
            //  this.selectedToppings[this.selectedToppings.length - 1];
          //return this.selectedToppings.slice(0, -1).join(', ') + lastTopping;
        //}

        //return this.selectedToppings.join('');
      //};
    //};
