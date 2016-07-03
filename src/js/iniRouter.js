/**
 * Created by KosiakMD on 20.06.16.
 *
 * initRouter
 * add gates to pathes
 * and controllers to pathes
 */
"use strict"
//
;(function initRouter(){
    console.log("#____Router Initialization");
    window.$Router = __simpleRouter();
    $Router.path().add({
        "/" : "views/index.html",
        "/about" : "views/about.html",
        "/donate" : "views/donate.html"
    }).path().add({
        "/feedback" : "views/feedback.html"
    }).controller("/", function(){
        paint();
        // adaptation();
    }).controller("/feedback", function(){
        $(window).trigger( 'load' );
    }).controller("", function(){
        // adaptation();
        $(document).ready(function(){
            adaptation()
        });
    });

    // $Router.controller().delete("/feedback")
    // .controller("/feedback", function(){
    //     $(window).trigger( 'load' );
    // });
    // console.log("zzzzzzz",$Router.get())
    console.log("Router INIT()");
    $Router.init();
    // $Router.reset();

    /*var app = angular.module( 'multiLang', ['ngRoute']);
     app.config( function ($routeProvider, $locationProvider) {
     $routeProvider
     .when("/",{
     // controller : "TranslateController",
     templateUrl : "views/index.html"
     })
     .when("/about",{
     // controller : "TranslateController",
     templateUrl : "views/about.html"
     })
     .when("/donate",{
     // controller : "TranslateController",
     templateUrl : "views/donate.html"
     })
     .when("/feedback",{
     //controller : "TranslateController",
     templateUrl : "views/feedback.html"
     })
     .otherwise({redirectTo : "/"});
     $locationProvider.html5Mode({
     enabled: true,
     requireBase: false,
     rewriteLinks : false//true
     })//.hashPrefix('#');
     });
     app.controller('TranslateController', function ml( $scope*//*, $routeParams*//*){
     //ml var $appElement = $('[ng-controller="TranslateController"]'),
     $scope = angular.element( $appElement ).scope();
     $scope.ml = Lang.text;*/
    /*$scope.$on('$viewContentLoaded', function() {
     console.log("viewContentLoaded")
     paint();
     adaptation();
     $(window).trigger( 'load' );
     });
     $scope.$on('$routeChangeSuccess', function () {
     console.log("routeChangeSuccess");
     menu_href();
     })
     });*/
}());