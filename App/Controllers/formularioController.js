angular.module('formularioSignUp', [])
  .controller('signUpController', function($scope) {

	$scope.app="Sign Up";
	
	$scope.contactos = [
	{nome:"pedro", telefone:"9999"},
	{nome:"Jonatan", telefone:"9999"},
	{nome:"Joana", telefone:"9999"},
	{nome:"Maria", telefone:"9999"},
	{nome:"Daniela", telefone:"19999"}
	];

	$scope.contas=[
		{nome:"Publico", codigo:0},
		{nome:"Artista", codigo:1},
		{nome:"Entidade de espetaculos", codigo:2},
	];

	$scope.AddContacto=function(contacto){
		$scope.contactos.push(angular.copy(contacto));
		delete $scope.contacto;
		$scope.contactoForm.$setPristine();
	};
	$scope.deleteContacto=function(contactos){
		$scope.contactos = contactos.filter(function(contacto){
			if (!contacto.selecionado) return contacto;
		});
	};
	$scope.isSelecionado = function(contactos){
		return contactos.some(function(contacto){
			return contacto.selecionado;
		});
	};	
});