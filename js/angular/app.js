var app = angular.module('dashboardApp', []);

app.controller('PageController', function($scope) {
    $scope.tab = 0;
    this.sites = ["Students", "Grades"];

    $scope.pageTitle = this.sites[$scope.tab];
});

app.controller('StudentController', function($scope, $http) {
    $http.get("students.php").then( function(response) {
       $scope.studentData = response.data;
    });   

});

app.controller('PhaseController', function($scope, $http) {
    $http.get("phases.php").then( function(response) {
       $scope.phaseData = response.data;
    });   

});

app.controller('SubscriberController', function($scope, $http) {
    $http.get("subscribers.php").then( function(response) {
        $scope.subscriberData = response.data;
    });
});

app.controller('LevelController', function($scope, $http) {
    $http.get("levels.php").then( function(response) {
        $scope.levelData = response.data;
    });
});

app.controller('StudentModalController', function() {
    
});

app.directive('studentList', function() {
    return {
        restrict: 'E',
        templateUrl: 'student-list.html',
        controller: 'StudentController',
        controllerAs: 'studentCtrl'
    };
});

app.directive('phaseList', function() {
    return {
        restrict: 'E',
        templateUrl: 'phase-list.html',
        controller: 'PhaseController',
        controllerAs: 'phaseCtrl'
    };
});

app.directive('subscriberList', function() {
    return {
        restrict: 'E',
        templateUrl: 'subscriber-list.html',
        controller: 'SubscriberController',
        controllerAs: 'subscriberCtrl'
    };
});

app.directive('levelList', function() {
    return {
        restrict: 'E',
        templateUrl: 'level-list.html',
        controller: 'LevelController',
        controllerAs: 'levelCtrl'
    };
});

app.directive('studentModal', function() {
    return {
        restrict: 'E',
        templateUrl: 'student-modal.html',
        controller: 'StudentModalController',
        controllerAs: 'studentModalCtrl'
    };
});