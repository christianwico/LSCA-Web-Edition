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