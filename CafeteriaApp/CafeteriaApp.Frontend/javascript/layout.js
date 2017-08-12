
app.controller('Language' , function ($scope,Languages) {

  $scope.languages=Languages.getLanguages();

	
});

