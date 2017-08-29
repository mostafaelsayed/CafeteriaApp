

// controller for getting menuitems of a category from database

app.controller('getMenuItemsAndCustomerOrder', function ($scope,$http,$location,$rootScope,$timeout,Order_Info) {

  $scope.categoryId = $location.search().categoryId;
  $scope.cafeteriaId = $location.search().cafeteriaId;
  
  $scope.getMenuItems = function() {
  
   $http.get('/CafeteriaApp.Backend/Requests/MenuItem.php?categoryId='+$scope.categoryId)
   .then(function(response) {
    //console.log(response);
       $scope.menuItems = response.data;
       $scope.loadFavoriteItems();
       $scope.initializeMenuItemCommmentFlags();
       $scope.loadRatedMenuItemsForUser();
   });
  }
 


  // $scope.getCurrentCustomer = function() {

  //   $http.get('/CafeteriaApp.Backend/Requests/Customer.php')
  //   .then(function(response) {
  //     $scope.customerId = response.data;
  //     //console.log($scope.customerId);
  //     if ($scope.customerId == undefined) {
  //       document.location = "/CafeteriaApp.Frontend/Views/login.php?redirect_to="+redirect_to;
  //     }
  //     else {
  //       ////console.log($scope.customerId);
  //      // $scope.getOrder();
  //     }
  //   });
  // }





  // $scope.getOrder = function() {
  //   $http.get('/CafeteriaApp.Backend/Requests/Order.php')
  //   .then(function(response) {
      
  //     $scope.currentOrder = response.data;
  //     $scope.orderId = $scope.currentOrder.Id;
    
  //     if ($scope.orderId == undefined) {
  //       $scope.orderId = null;
  //       $scope.orderItems = [];
     
  //       $scope.TotalPrice = 0;
  //     }
    
  //     else if($scope.orderId != undefined) {
  //       $scope.getOrderItems();
  //     }
     
  //   });
  // }

  

  $scope.addToOrder = function(menuItem) {
    ////console.log(1);
    var x = $rootScope.orderItems.filter(o => o.MenuItemId == menuItem.Id);
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
      ////console.log($scope.orderId);
      $http.post('/CafeteriaApp.Backend/Requests/OrderItem.php',data)
      .then(function(response) {
        //console.log(response);
        $scope.orderId = response.data;
      $scope.togglePopup('Menu Item added successfully !');
      Order_Info.getOrderItems(  $scope.orderId);
      });
    }
  }



   $scope.increaseQuantity =function (OrderItem) 
 { Order_Info.increaseQuantity(OrderItem);
 $scope.togglePopup( 'Menu Item added successfully  !');
}

$scope.decreaseQuantity =function (OrderItem) 
 { Order_Info.decreaseQuantity(OrderItem);
   $scope.togglePopup( 'Menu Item removed successfully  !');
}

$scope.deleteOrderItem =function (OrderItem) 
 { Order_Info.deleteOrderItem(OrderItem);
   $scope.togglePopup('Menu Item removed successfully !');
}




$scope.toggleFavoriteItem = function(menuItemId) {
    var data = {
        menuItemId: menuItemId
      };

   if ( document.getElementById('favorites'+menuItemId).style.color==="red")//add favorite
    {
      $http.post('/CafeteriaApp.Backend/Requests/FavoriteItem.php',data)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById('favorites'+menuItemId).style.color="yellow";
            $scope.togglePopup('favorite Item added successfully !');

        }

      });
    }
    else
    {////console.log('HI');
  
  $http.delete('/CafeteriaApp.Backend/Requests/FavoriteItem.php?Id='+menuItemId)
      .then(function(response) {
        if(response.data!=="")
        {
        alertify.error( response.data);
        }
        else{

          document.getElementById("favorites"+menuItemId).style.color="red";
          $scope.togglePopup('favorite Item removed successfully !');

        }

      });


    }
    
  }

$scope.loadFavoriteItems = function() {

 $http.get('/CafeteriaApp.Backend/Requests/FavoriteItem.php')
   .then(function(response) {
       $scope.favoItems = response.data;

for (var i =0 ; i < $scope.menuItems.length; i++) {
       for (var j = 0 ; j < $scope.favoItems.length; j++) {
         
       if($scope.menuItems[i].Id ==$scope.favoItems[j].MenuItemId)
       {
      document.getElementById('favorites'+$scope.menuItems[i].Id).style.color="yellow";
       }
        }
}
//var x = $scope.favoItems.filter(o => o.MenuItemId == $scope.menuItems[i].Id);  

   });
}



$scope.initializeMenuItemCommmentFlags=function(){

//1-  create flages

for (var i = 0 ; i < $scope.menuItems.length ;  i++) {
  
  $scope.ShowHides.push(false);  
  $scope.add_edits.push(true);  
  $scope.commentDetails.push("");

}

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
    return yyyy+'/'+mm+'/'+dd;//to work with db format

}



$scope.loadCommentsforMenuItem = function (menuItemId,menuItemIndex){

 $http.get('/CafeteriaApp.Backend/Requests/Comment.php?MenuItemId='+menuItemId)
   .then(function(response) {
    console.log(response);
      $scope.comments[menuItemIndex] = response.data[0];

    $scope.customerCommentsIds[menuItemIndex] = response.data[1];
     
//var x = $scope.favoItems.filter(o => o.MenuItemId == $scope.menuItems[i].Id);  

   });


}


$scope.toggleMenuItemComments = function (menuItemIndex,menuItemId){
$scope.ShowHides[menuItemIndex]=! $scope.ShowHides[menuItemIndex];

if($scope.ShowHides[menuItemIndex])
{
$scope.loadCommentsforMenuItem(menuItemId,menuItemIndex);
}

}


$scope.addCommentBackAndFront = function (menuItemIndex,menuItemId,commentDetails,CustomerName,add_update){
  if($scope.commentDetails[menuItemIndex]!==""  ) // check empty box doesn't work
  {
  
  if(add_update){

  var date=$scope.getCurrentDate(); 
  var data ={
    Details:commentDetails ,
    MenuItemId:menuItemId,
    Date:date
          };
          
 $http.post('/CafeteriaApp.Backend/Requests/Comment.php',data)
      .then(function(response) { //response.data=id of new comment
        if(response.data!=="")
        { 
          $scope.customerCommentsIds[menuItemIndex].push(response.data);
          $scope.comments[menuItemIndex].push({UserName:CustomerName , Date:date ,Details:commentDetails,Id:response.data });

        }
        else{
                alertify.error( response.data);
        }
      });
    }

  else {//update

    $scope.updateCommentBackAndFront (menuItemIndex, menuItemId , commentDetails);

    }
   
       $scope.commentDetails[menuItemIndex]="";

  }
 
}


$scope.updateCommentBackAndFront = function (menuItemIndex,menuItemId,commentDetails){
  var date=$scope.getCurrentDate(); 

  var data ={Details:commentDetails ,
       Id:$scope.comments[menuItemIndex][$scope.commentIndex].Id,
          };  

 $http.put('/CafeteriaApp.Backend/Requests/Comment.php',data)
      .then(function(response) { //response.data=id of new comment
        if(response.data!=="")
        {
           alertify.error( response.data);

        }
        else{ //update page content
          $scope.comments[menuItemIndex][$scope.commentIndex].Details=commentDetails ;
          $scope.comments[menuItemIndex][$scope.commentIndex].Date=date;
        document.getElementById('addUpdateBtn'+menuItemIndex).value='Add';
       $scope.add_edits[menuItemIndex]=true;
              
        }

      });
}


$scope.editComment=function(commentIndex,menuItemIndex)
{
    $scope.commentIndex=commentIndex;
  $scope.toggleUpdateAddButton(menuItemIndex,$scope.comments[menuItemIndex][commentIndex].Details );

}

$scope.toggleUpdateAddButton=function(menuItemIndex,commentDetails)
{
  $scope.commentDetails[menuItemIndex]=commentDetails;
if($scope.add_edits[menuItemIndex])
{
  document.getElementById('addUpdateBtn'+menuItemIndex).value='Update';
   $scope.add_edits[menuItemIndex]=false;
}

}


$scope.deleteComment= function(commentId , commentIndex , menuItemIndex)
{
 if($scope.add_edits[menuItemIndex]){//only if not in edit mode
 
 $http.delete('/CafeteriaApp.Backend/Requests/Comment.php?id='+commentId)
      .then(function(response) {
        if(response.data != "")
        {
        alertify.error( response.data);
        }
        else{

          $scope.customerCommentsIds[menuItemIndex].splice($scope.customerCommentsIds[menuItemIndex].indexOf($scope.comments[menuItemIndex][commentIndex].Id),1);
          $scope.comments[menuItemIndex].splice(commentIndex,1);


        }

      });
}
}


$scope.checkEditAndRemove=function(commentId,index)
{      
 return $.inArray( commentId , $scope.customerCommentsIds[index]) === -1 ? false : true;

}


// $scope.ShowCallsInNGRepeat=function () {
  
//      //console.log(1);
//     return true;
// }

$scope.loadRatedMenuItemsForUser = function (){

 $http.get('/CafeteriaApp.Backend/Requests/Rating.php')
   .then(function(response) {

       $scope.ratedMenuItemsIds=response.data[1];//for updating 

       for (var j = 0 ; j < $scope.menuItems.length ; j++) {
          for (var i = 0; i < response.data[0].length; i++) {
            if ($scope.menuItems[j].Id===response.data[0][i][0] )
            $scope.ItemRating[j]=response.data[0][i][1];//get the value of rating for item of index j

       }

       }
      
      
   });

}

$scope.checkaddUpdateRating=function (MenuItemId) {
 return $.inArray( MenuItemId , $scope.ratedMenuItemsIds) === -1 ? false : true;

}



$scope.addRatingOrUpdate=function(MenuItemId,value)
{
  if($scope.checkaddUpdateRating(MenuItemId))//update
  {
    var data={MenuItemId:MenuItemId,
      Value:value

    };

    $http.put('/CafeteriaApp.Backend/Requests/Rating.php',data)
        .then(function(response) {
          if(response.data!=="")
          {// 
            $scope.togglePopup('Item rateing updated successfully !');
        //  alertify.error( response.data);
          }
          else{  
              
           console.log(response);
            // hide the stars ,show thanks !
          }

        });

  }
  else{           //add

  var data={MenuItemId:MenuItemId,
    Value:value

  };

  $http.post('/CafeteriaApp.Backend/Requests/Rating.php',data)
      .then(function(response) {
        if(response.data!=="")
        { 
           $scope.ratedMenuItemsIds.push(MenuItemId);

      for (var i = $scope.menuItems.length - 1; i >= 0; i--) {
              if($scope.menuItems[i].Id==MenuItemId)   
                $scope.menuItems[i].RatingUsersNo++;
          }
        $scope.togglePopup('Item rateing added successfully !');

        //console.log(  x.RatingUsersNo);
      //  alertify.error( response.data);
        }
        else{  
             
         
          // hide the stars ,show thanks !
        }

      });

  }
 
}

$scope.togglePopup=function (message) {
       var popup = document.getElementById("myPopup");
      popup.innerHTML  =message;
      popup.classList.toggle("show");
      $timeout(function() {
        popup.classList.toggle("show");
      }, 2000);
}

  var self = this;

$scope.commentDetails = [];//menuitems
$scope.add_edits = [];//menuitems
$scope.ShowHides = [];//menuitems
$scope.comments = [];//menuitems
$scope.customerCommentsIds = [];//menuitems
 $scope.ItemRating=[];
 
//$scope.getCurrentCustomer();

 // $scope.$watch(
 //                    "Order_Info.orderItems",
 //                    function handleFooChange( newValue, oldValue ) {
 //                       $scope.orderItems =oldValue;
 //                       console.log(oldValue);
 //                    },true
 //                );

$scope.getMenuItems();

 //self.orderItems = Order_Info.orderItems;


//can use menuitem id instead of index to discriminate the indexes of the array




});



