var demoApp = angular.module('demoApp', ['ui.bootstrap']);
demoApp.controller("pagingCtrl", function($scope) {
  $scope.itemsPerPage = 3;
  $scope.currentPage = 1;
  $scope.friends = [
    { id: 1, name: "相田",   age: 20 ,address: "東京都品川区"},
    { id: 2, name: "伊藤",   age: 55 ,address: "神奈川県横浜市"},
    { id: 3, name: "上野",   age: 20 ,address: "埼玉県川越市"},
　　　　　　　：
  ];
  $scope.range = function() {
    $scope.maxPage = Math.ceil($scope.friends.length/$scope.itemsPerPage);
    var ret = [];
    for (var i=1; i<=$scope.maxPage; i++) {
      ret.push(i);
    }
    return ret;
  };
  $scope.setPage = function(n) {
    $scope.currentPage = n;
  };
  $scope.prevPage = function() {
    if ($scope.currentPage > 1) {
      $scope.currentPage--;
    }
  };
  $scope.nextPage = function() {
    if ($scope.currentPage < maxPage) {
      $scope.currentPage++;
    }
  };
  $scope.prevPageDisabled = function() {
    return $scope.currentPage === 1 ? "disabled" : "";
  };

  $scope.nextPageDisabled = function() {
    return $scope.currentPage === $scope.maxPage ? "disabled" : "";
  };
})
demoApp.filter('offset', function() {
  return function(input, start) {
    start = parseInt(start);
    return input.slice(start);
  };
})
