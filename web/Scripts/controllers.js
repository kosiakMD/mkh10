    angular.module('mkh10.controllers', [])

    //fun code
    .controller('ClassesCtr', function ($scope, $http, $rootScope) {
        
        $scope.classes = [];

        $scope.popArray = function () {
            $rootScope.siteMap.pop();
        }

        $scope.addSiteMap = function (index) {
            $rootScope.siteMap.push($scope.classes[index]);
        }

        $scope.$on("$routeChangeSuccess", function () {
            $http.get('api.php?get=class').success(function (response) {
                $scope.classes = JSON.parse(angular.fromJson(response));
                $rootScope.siteMap = [];
            });
        });

    })
    .controller('BlocksCtr', function ($scope, $http, $location, $templateCache, $routeParams, $rootScope) {
        $scope.blocks = [];
        $scope.father = 0;
        
        $scope.popArray = function () {
            $rootScope.siteMap.pop();
        }

        $scope.addSiteMap = function (index) {
            $rootScope.siteMap.push($scope.blocks[index]);
        }


        $scope.$on("$routeChangeSuccess", function () {
            var id = $routeParams["classId"];
            var blockId = $routeParams['blockId'];
            
            if (id !== 'undefined') {
                $rootScope.classId = id;    
                var url = 'api.php?get=class/' + id;
                $http.get(url).success(function (response) {
                    $scope.blocks = JSON.parse(angular.fromJson(response));
                    $scope.father = $scope.blocks[0].FatherId;
                });

            }
        });


    })
    .controller('NosologyCtr', function ($scope, $http, $routeParams, $rootScope) {
        $scope.nosology = [];
        

        $scope.father = 0;
        $scope.popArray = function () {
            $rootScope.siteMap.pop();
        }

        $scope.addSiteMap = function (index) {
            $rootScope.siteMap.push($scope.nosology[index]);
        }

        $scope.$on("$routeChangeSuccess", function () {
            var id = $routeParams["blockId"];
            $rootScope.blockId = id; 
            var url = 'api.php?get=block?id=' + id;
            $http.get(url).success(function (response) {
                $scope.nosology = JSON.parse(angular.fromJson(response));
                $scope.father = $scope.nosology[0].FatherId;
            });
        });
    })
    .controller('DiagnosisCrt', function ($scope, $http, $routeParams, $rootScope) {
        
        $scope.diagnisis = [];
        $scope.diagn = {};
        $scope.father = 0;


        $scope.addSiteMap = function (index) {
            $rootScope.siteMap.push($scope.diagnisis[index]);
        }
        
        $scope.popArray = function () {
            $rootScope.siteMap.pop();
        }

        $scope.$on("$routeChangeSuccess", function () {
            var id = $routeParams["nosologyId"];
            var diagnosisId = $routeParams["diagnosisId"];
            if (id != undefined) {
                $rootScope.nosologyId = id;
                var url = 'api.php?get=nosology/' + id;
                $http.get(url).success(function (response) {
                    $scope.diagnisis = JSON.parse(angular.fromJson(response));
                    $scope.father = $scope.diagnisis[0].FatherId;
                });
            }
            if (diagnosisId != undefined) {
                $scope.father = diagnosisId;
                $rootScope.diagnosisId = diagnosisId;
                var url = 'api.php?get=diagnosis/' + diagnosisId;
                $http.get(url).success(function (response) {
                    $scope.diagn = JSON.parse(angular.fromJson(response));
                    
                });
            }
        });
    })
    .controller('GlobalCtr', function ($scope, $http, $rootScope) {
        $scope.result = [];
        $scope.if = false;
        $scope.globalText = '';
        $rootScope.siteMap = [];

        $rootScope.classId = 1;
        
        $rootScope.blockId = 1;

        $rootScope.nosoologyId = 1;

        $rootScope.diagnosisId = 1;


        $scope.popArray = function () {
            $rootScope.siteMap.pop();
        }


        $scope.getResult = function () {
            if ($scope.globalText.length > 1) {
                $scope.if = true;
                var url = 'api.php?get=diagnosis?text=' + $scope.globalText;
                $http.get(url).success(function (response) {
                    $scope.result = JSON.parse(angular.fromJson(response));
                });
            }
            else {
                $scope.if = false;
            }
        }
    });