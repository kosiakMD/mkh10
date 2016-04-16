'use strict';

angular.module('mkh10', ['mkh10.controllers', 'ngRoute', 'ngAnimate', 'HashBangURLs']).config(function ($routeProvider) {

    $routeProvider.when('/', {
        templateUrl: 'templates/Classes',
        controller: 'ClassesCtr'
    });
    $routeProvider.when('/blocks/:classId', {
        templateUrl: 'templates/Block',
        controller: 'BlocksCtr'
    });
    $routeProvider.when('/nosology/:blockId', {
        templateUrl: 'templates/Nosology',
        controller: 'NosologyCtr'
    });
    $routeProvider.when('/diagnosis/:diagnosisId',
    {
        templateUrl: 'templates/DiagnosisItem',
        controller: 'DiagnosisCrt'
    });

    
    
    $routeProvider.otherwise({ redirectTo: '/' });
});
angular.module('HashBangURLs', []).config(['$locationProvider', function ($location) {
    $location.hashPrefix('!');
}]);
    

