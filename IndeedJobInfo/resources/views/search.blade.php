<!DOCTYPE html>
<html lang="en" ng-app="companySearchApp">
<head>
  <meta charset="UTF-8">
  <title>Search Canaca Company</title>
  <link rel="stylesheet" href="{{ URL::asset('css/default.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" type="text/css">
</head>
<body style="width:340px; margin:0" ng-controller="CompanyCtrl">
  <script src="{{{asset('/js/angular.min.js')}}}"></script>

  <div id="header"></div>

  <div id="contents">
    <h3 align="center">Search Result</h3>

    <div id="searchForm">
      <form action="post" style="margin-bottom:30px;">
        <label for="name">Company Name</label>
        <input type="text" name="companyName" size="10" maxlength="10" style="width:155px"><br>

        <label for="name">City</label>
        <select name="city" id="city" style="width:155px">
          <option value=""></option>
          <option value=""></option>
          <option value=""></option>
        </select><br>

        <label for="name">Province</label>
        <select name="province" id="province" style="width:155px">
          <option value=""></option>
          <option value=""></option>
          <option value=""></option>
        </select><br>

        <label for="name">KeyWord</label>
        <select name="keyword" id="keyword" style="width:155px">
          <option value=""></option>
          <option value=""></option>
          <option value=""></option>
        </select><br>

        <label for="name">Job Title</label>
        <input type="text" name="jobTitle" size="10" maxlength="10">
      </form>
      <br>
    </div>

    <div id="resultTable" align="center">
      <h3>Search Result</h3>

      <div ng-repeat="company in data | orderBy:'-CompanyId'">
        <table border="1" style="margin-bottom:10px; width:300px;">
          <tr>
            <td colspan="3" class="col-xs-12"><% company.CompanyName %></td>
          </tr>
          <tr>
            <td class="col-xs-4"><% company.City %></td>
            <td class="col-xs-4"><% company.Province %></td>
            <td class="col-xs-4"><% company.KeyWord %></td>
          </tr>
          <tr>
            <td colspan="3"><% company.JobTitle %></td>
          </tr>
          <tr>
            <td colspan="3"><% company.Link %></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div id="footer"></div>

  <script type="text/javascript">
    var app = angular.module('companySearchApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    app.controller('CompanyCtrl', function($scope, $http){
      $http.get('/json')
        .then(function(response){
          $scope.data = response.data;
        });
    });

  </script>

</body>
</html>