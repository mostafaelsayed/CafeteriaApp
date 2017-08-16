

// controller for getting menuitems of a category from database

app.controller('getMenuItemsAndCustomerOrder', function ($scope,$http,$location) {

  $scope.categoryId = $location.search().id;


  $scope.getMenuItems = function() {
  
   $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
   .then(function(response) {
       $scope.menuItems = response.data;
       $scope.loadFavoriteItems();
       $scope.initializeMenuItemCommmentFlags();
   });
  }
 


  $scope.getCurrentCustomer = function() {

    $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
    .then(function(response) {
      $scope.customerId = response.data.Id;
      //console.log($scope.customerId);
      if ($scope.customerId == undefined) {
        document.location = "/CafeteriaApp.Frontend/Views/login.php";
      }
      else {
        //console.log($scope.customerId);
        $scope.getOrder();
      }
    });
  }


  $scope.getOrderItems = function() {
    $http.get('/CafeteriaApp.Backend/Requests/OrderItem.php?orderId='+$scope.orderId)
    .then(function(response) {
      //console.log(response.data);
      $scope.orderItems = response.data;
      //console.log(response.data);
      //$scope.TotalPrice = $scope.getTotalPrice();
    });
  }


  $scope.getOrder = function() {
    //console.log($scope.customerId);
    $http.get('/CafeteriaApp.Backend/Requests/Order.php')
    .then(function(response) {
      //console.log(response);
      $scope.currentOrder = response.data;
      $scope.orderId = $scope.currentOrder.Id;
      //console.log($scope.orderId);
      if ($scope.orderId == undefined) {
        $scope.orderId = null;
        $scope.orderItems = [];
        //console.log($scope.orderItems);
        $scope.TotalPrice = 0;
      }
      //console.log($scope.orderId);
      else if($scope.orderId != undefined) {
        $scope.getOrderItems();
      }
     
    });
  }



  

  $scope.addToOrder = function(menuItem) {
    //console.log(1);
    var x = $scope.orderItems.filter(o => o.MenuItemId == menuItem.Id);
    if(x.length > 0) {
      $scope.increaseQuantity(x[0]); // we extract the first element because x is array (x must be one length array)
    }
    else {
      var data = {
        OrderId: $scope.orderId,
        MenuItemId: menuItem.Id,
        Quantity: parseInt(1)
        //CustomerId: $scope.customerId
      };
      //console.log($scope.orderId);
      $http.post('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        //console.log(response);
        $scope.orderId = response.data;
        $scope.getOrderItems();
      });
    }
  }



  $scope.increaseQuantity = function(orderItem) {
    if($scope.orderId != null) {
      var data = {
        Id: orderItem.Id,
        Quantity: parseInt(orderItem.Quantity)+1,
        Flag: true
      };
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        //console.log(response);
        $scope.getOrderItems();
      });
    }
  }


  $scope.decreaseQuantity = function(orderItem) {
    var data = {
      Id: orderItem.Id,
      Quantity: parseInt(orderItem.Quantity)-1,
      Flag: false
    };
    if (orderItem.Quantity > 1) {
      $http.put('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        $scope.getOrderItems();
      });
    }
    else {
      $scope.deleteOrderItem(orderItem);
    }
  }


  $scope.deleteOrderItem = function(orderItem) {
    $http.delete('/CafeteriaApp.Backend/Requests/OrderItem.php?id='+orderItem.Id)
    .then(function(response) {
      $scope.getOrderItems();
    });
  }


$scope.toggleFavoriteItem = function(menuItemId) {
    var data = {
        menuItemId: menuItemId
      };

   if ( document.getElementById('favorites'+menuItemId).style.color==="red")
    {
      $http.post('/CafeteriaApp.Backend/Requests/FavoriteItem.php',data)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById('favorites'+menuItemId).style.color="yellow";
        }

      });
    }
    else
    {//console.log('HI');
  
  $http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?Id='+menuItemId)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById("favorites"+menuItemId).style.color="red";
        }

      });


    }
    
  }

$scope.loadFavoriteItems = function() {

 $http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
   .then(function(response) {
       $scope.favoItems = response.data;

for (var i = $scope.menuItems.length - 1; i >= 0; i--) {
       for (var j = $scope.favoItems.length - 1; j >= 0; j--) {
         
       if($scope.menuItems[i].Id ==$scope.favoItems[j].MenuItemId)
       {
      document.getElementById('favorites'+$scope.menuItems[i].Id).style.color="yellow";
       }
        }
}
//var x = $scope.favoItems.filter(o => o.MenuItemId == $scope.menuItems[i].Id);  

   });
}


$scope.ShowHides = new Array();
$scope.initializeMenuItemCommmentFlags=function(){

//1-  create flages

for (var i = $scope.menuItems.length - 1; i >= 0; i--) {
  
  $scope.ShowHides.push(false);  
}
//ShowHide='Show Comments';
}


$scope.getCurrentDate=function(){
 //  var dateform = ` ${date.getUTCDay()}/${date.getUTCMonth()}/${date.getFullYear()}`
  var today = new Date();
var dd = today.getDate();//get day
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd;
} 
if(mm<10){
    mm='0'+mm;
} 
    return dd+'/'+mm+'/'+yyyy;

}


$scope.AddCommentinPageOnly = function (MenuItemId,commentDetails,CustomerName){
//var code = (e.keyCode ? e.keyCode : e.which);//which for firefox
   // if(code == 13) { //Enter keycode
   // alert('enter press');
  MenuItemId ='tbody'+MenuItemId;
  //console.log(MenuItemId);
      var hr = document.createElement("hr");
   var tr1 = document.createElement("tr");
var tdCustomer = document.createElement("td");
    var textCustomer = document.createTextNode(CustomerName);
    tdCustomer.appendChild(textCustomer);
     var tdDate = document.createElement("td");
    var textDate = document.createTextNode($scope.getCurrentDate());
    tdDate.appendChild(textDate);
      tr1.appendChild(tdCustomer);
      tr1.appendChild(tdDate);
   var tr2 = document.createElement("tr");
   var tdComment = document.createElement("td");
    var textComment = document.createTextNode(commentDetails);
    tdComment.appendChild(textComment);
    tr2.appendChild(tdComment);
  document.getElementById(MenuItemId).appendChild(tr1);
    document.getElementById(MenuItemId).appendChild(tr2);

    document.getElementById(MenuItemId).appendChild(hr);

    //console.log(Id);
//}
}



$scope.loadCommentsforMenuItem = function (MenuItemId){

 $http.get('/CafeteriaApp.Backend/Requests/Comment.php?MenuItemId='+MenuItemId)
   .then(function(response) {
      for (var i = response.data.length - 1; i >= 0; i--) {
       $scope.AddCommentinPageOnly(MenuItemId,response.data[i].Details,response.data[i].UserName);
      }

//var x = $scope.favoItems.filter(o => o.MenuItemId == $scope.menuItems[i].Id);  

   });


}


$scope.ToggleMenuItemComments = function (index,MenuItemId){
$scope.ShowHides[index]=! $scope.ShowHides[index];

if($scope.ShowHides[index])
{
$scope.loadCommentsforMenuItem(MenuItemId);
}

}


$scope.AddCommentBackAndFront = function (MenuItemId,commentDetails,CustomerName){

var data ={Details:commentDetails ,
    MenuItemId:MenuItemId
          };  


 $http.post('/CafeteriaApp.Backend/Requests/Comment.php',data)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{
          
          $scope.AddCommentinPageOnly (MenuItemId,commentDetails,CustomerName);
        }

      });
}



$scope.getCurrentCustomer();
$scope.getMenuItems();





});


