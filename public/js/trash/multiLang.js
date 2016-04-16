/*!
keleborn.mail@gmail.com
МКХ 10 - ( ICD 10 )
(c) 2015 Anton Kosiak <keleborn.mail [at] gmail.com>
*/
//------------- Angular JS -------------//
//var app = angular.module("multiLang", []);
//app.controller('TranslateController', [function($scope) {
	
//var app = angular.module('multiLang', []);
//app.controller('TranslateController', function($scope) {
//^(.){1,2}[a-z,A-z]{1}
//}]);

  //console.log("ng");
  //$scope.Home = "Головна"
  /*
function TranslateController($scope) {
  $scope.Home = "Головна";
}
*/
angular.module('multiLang', []).controller('TranslateController', function($scope, $http) {
	$http.get('lang/uk.json').success(function(data) {
        $scope.ml = data;
    });
	//$scope.ml = Lang.text;
});