
function selectpickerDirective($parse) {
  return {
    restrict: 'A',
    priority: 1000,
    link: function (scope, element, attrs) {

        //New change
        scope.$watch(attrs.ngModel, function(n, o){
          element.selectpicker('val', $parse(n)());
          element.selectpicker('refresh');
        });

    }
  };
}

 app.directive('selectPicker', ['$parse', selectpickerDirective]);



app.controller('Language_Order' ,['$scope','$http','Order_Info','$q',function ($scope,$http,Order_Info,$q) {


$scope.changeLanguage=function (languageId) {
 //$timeout(function () {
       //}, 1000);
    var data={langId:languageId};
  $http.post('/CafeteriaApp.Backend/Requests/Languages.php',data)
.then(function(response) {
  location.reload();
  //document.location=<?php //echo "\"{$_SERVER['PHP_SELF']}\"" ;//current executing script , __FILE__ gets the current file?>
},function(response) {

    console.log( "Something went wrong");
}
);

}

// $scope.getOrder = function() {
//   var q = $q.defer();
//   $scope.orderItems = Order_Info.getOrder();
//   //console.log($scope.orderItems);
//   if ($scope.orderItems != null) {
//     q.resolve($scope.orderItems);
//  }
// }
Order_Info.getOrder().then(function(x) {
  $scope.orderItems = Order_Info.orderItems;
  //console.log($scope.orderItems);
})

// $q(Order_Info.getOrder()).then(function() {
//   $scope.orderItems = Order_Info.orderItems;

// })
// $q(function(resolve, reject) {
//   Order_Info.getOrder().then(Order_Info.orderItems);
// }).then(doSomething);

// function doSomething() {
//   $scope.orderItems = Order_Info.orderItems;
// }


// var promise = Promise.resolve(Order_Info.getOrder());
 // Order_Info.getOrder().then(function(){$scope.orderItems = Order_Info.orderItems;console.log($scope.orderItems);});
 //});
 

 // $scope.orderItems = Order_Info.orderItems; 


 $scope.increaseQuantity =function (OrderItem) 
 { Order_Info.increaseQuantity(OrderItem);
}
 
 $scope.$on('loadOrderItems',function(data) {
 $scope.orderItems =data;
 })

  
}]);


    $(document).ready(function () {

        // ANIMATEDLY DISPLAY THE NOTIFICATION COUNTER.
        // $('#noti_Counter')
        //     .css({ opacity: 0 })
        //     .text('7')              // ADD DYNAMIC VALUE (YOU CAN EXTRACT DATA FROM DATABASE OR XML).
        //     .css({ top: '-10px' })
        //     .animate({ top: '-2px', opacity: 1 }, 500);

        $('#shoppingCart_Button').click(function () {

            // TOGGLE (SHOW OR HIDE) NOTIFICATION WINDOW.
            $('#shoppingCartDetails').fadeToggle('fast', 'linear', function () {
                if ($('#shoppingCartDetails').is(':hidden')) {
                    // $('#shoppingCart_Button').css('background-color', '#2E467C');
                }
                // else $('#shoppingCart_Button').css('background-color', '#FFF');        // CHANGE BACKGROUND COLOR OF THE BUTTON.
            });

            // $('#noti_Counter').fadeOut('slow');                 // HIDE THE COUNTER.

            return false;
        });

        // HIDE NOTIFICATIONS WHEN CLICKED ANYWHERE ON THE PAGE.
        $(document).click(function () {
            $('#shoppingCartDetails').hide();

            // CHECK IF NOTIFICATION COUNTER IS HIDDEN.
            // if ($('#noti_Counter').is(':hidden')) {
            //     // CHANGE BACKGROUND COLOR OF THE BUTTON.
            //     $('#shoppingCart_Button').css('background-color', '#2E467C');
            // }
        });

        $('#shoppingCartDetails').click(function () {
            return false;       // DO NOTHING WHEN CONTAINER IS CLICKED.
        });
    });

