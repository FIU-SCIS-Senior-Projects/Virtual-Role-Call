
/* global officer */

officer.controller('OfficerController', ['$scope',
    function ($scope) {
//        , 'DataRequest', '$routeParams', 'Idle', '$modal'
//, DataRequest, $routeParams, Idle, $modal
        $scope.tasks = [
            {taskName: 'Bolo', url: "#"},
            {taskName: 'Message from the Chief', url: "#"},
            {taskName: 'Internal Memo', url: "#"},
            {taskName: 'Shift Lineup', url: "#"},
            {taskName: 'Traning', url: "#"},
            {taskName: 'Watch Orders', url: "#"}
        ];
    }]);