function displayForm() {
	//$("#feedbackForm").css({ display: 'block' });
	$(".background").fadeToggle("slow");
	$(".container").css({'z-index': '-1'});
}

$(document).ready(function() {
	$(".background").click(function(e) {     
    $(".background").css({'display': 'none'});
  }).children().click(function(e) {
  	return false;
	});
});

	 // if($(e.target).is('#feedbackForm')||$(e.target).is('form')){
        //     e.preventDefault();
        //     return;
        // }

  // $(document).click(function () {

  //     $(".background").css({'display':'none'});
     
  //   });

layoutApp.controller('feedback', function($scope, $http) {
	$scope.getFeedbackAbouts = function() {
	 $http.get('/myapi/FeedbackAbouts')
	 .then(function (response) {	
      $scope.abouts = response.data;
    });
	};

  $scope.addFeedback = function(name, mail, phone, selectedAbout, message, answer) {
    console.log($scope.result);

    if (answer == $scope.result) {
      var data = {
        Name: name,
        Phone: phone,
        Message: message,
        Mail: mail,
        SelectedAboutId: selectedAbout.Id
      };

      $http.post('/myapi/VisitorFeedback', data)
      .then(function(response) {
        if (response.data === "") {
        	$scope.failure = true;
          $scope.success = false;
          $scope.SummationWrong = false;
        }
        else {
        	if ( !parseInt(response.data) ) {
            $scope.success = true;
            $scope.SummationWrong = false;
          }
        	else {
            $scope.failure = true;
          }
          
          $scope.success = false;
          $scope.SummationWrong = false;
        }
      });
    }
    else {
      $scope.SummationWrong = true;
      $scope.success = false;
      $scope.failure = false;
    }
  };

  $scope.getFeedbackAbouts();
});