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

var layoutApp = angular.module('layout_app',['order_service','location_provider']);

layoutApp.directive('selectPicker', ['$parse', selectpickerDirective]);

layoutApp.controller('Language_Order',['$rootScope','$scope','$http','Order_Info',function ($rootScope,$scope,$http,Order_Info) {

    $scope.changeLanguage=function (languageId) {
        //$timeout(function () {
        //}, 1000);
        var data={langId:languageId};

        $http.post('/CafeteriaApp.Backend/Requests/Languages.php',data)
        .then(function(response) {
            location.reload();
            //document.location=<?php //echo "\"{$_SERVER['PHP_SELF']}\"" ;//current executing script , __FILE__ gets the current file?>
        });
        // handle error too
    }

    Order_Info.getOrderItems($scope.orderId);

    $scope.increaseQuantity =function (OrderItem) {
        Order_Info.increaseQuantity(OrderItem);
    }

    $scope.decreaseQuantity =function (OrderItem) {
        Order_Info.decreaseQuantity(OrderItem);
    }

    $scope.deleteOrderItem =function (OrderItem) {
        Order_Info.deleteOrderItem(OrderItem);
    }

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