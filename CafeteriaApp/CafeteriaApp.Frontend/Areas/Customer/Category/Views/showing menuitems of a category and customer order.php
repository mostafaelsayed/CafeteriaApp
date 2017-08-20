<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  require_once('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>
<title>MenuItems</title>

<script src="/CafeteriaApp.Frontend/javascript/showing menuitems of a category and customer order.js"></script>
<link href="/CafeteriaApp.Frontend/css/customer styles.css" rel="stylesheet">
<style type="text/css">
  
.blueTable{

border: 1px solid blue;
 /*width = 500px;*/
}

  .blueTable>tr{
    margin: 10px;
    /*color: white;*/
  }
   .blueTable>td{
  text-align:center;
    margin: 10px;
    color: white;
  }

</style>

<h1 style="margin-top:70px">MenuItems</h1>

<div class="row"  ng-controller="getMenuItemsAndCustomerOrder" ng-init="customer='<?php echo $_SESSION['userName']; ?>'" >
    <div class="col-lg-2">
      <a href="#" style="color:white;margin-left:40px">Back</a>
      <br><br>
      <a href="#" style="color:white;margin-left:40px">About This category</a>
    </div>


    <div class="col-lg-5">
      <div ng-repeat="m in menuItems" style="width:90%;margin-left:40px">
        <h1 ng-bind="m.Name" class="menu-name" ></h1>
        
        <!-- <h2 ng-show="ShowCallsInNGRepeat()"></h2> -->

        <a id="{{'favorites'+m.Id}}" title="add to favorites" style="color:red;float:right;" ng-click="toggleFavoriteItem(m.Id)" class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-heart"></span></a>



        <a title="Add To Order" id="creatNewCafeteria" ng-click="addToOrder(m)" class="btn btn-circle" style="color:white;float:right;margin-top:-40px"><i class="fa fa-plus"></i></a>
    

     <a  title="Show/Hide Comments" style="color:blue;float:right;" ng-click="toggleMenuItemComments($index,m.Id)" class="btn btn-lg">
          <span class="" >{{ ShowHides[$index] ?'Hide Comments':'Show Comments'}}</span></a>


        <div style="color:white;font-style:italic">Name:  <span ng-bind="m.Name" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Price:  <span ng-bind="m.Price" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Description:  <span ng-bind="m.Description" style="color:white"></span></div>
        


        <table class="blueTable" id="{{'comments'+m.Id}}" ng-if="ShowHides[$index]"  >
          <caption style="color:blue;font-weight:bold;">{{m.Name}} Comments</caption>
         
          <tbody id="" >
        <tr ng-repeat="comm in comments[$index]">
          <td>{{comm.UserName}}</td>
          <td>{{comm.Date}}</td>
         
          <td><p>{{comm.Details}} &nbsp;&nbsp;</p> </td>

          <td ng-if="checkEditAndRemove(comm.Id, menuItems.indexOf(m))">
          <a style="cursor: pointer;" ng-click="editComment( $index , menuItems.indexOf(m))">edit</a> &nbsp; <a ng-click="deleteComment( comm.Id, $index , menuItems.indexOf(m) )"  style="cursor: pointer;" >remove</a>
          </td>
       </tr>
        </tbody>

           <tbody>
          <tr>   
          <!-- <textarea ng-KeyPress="$event.keyCode ==13 ? addCommentBackAndFront(m.Id,commentDetails,customer) :null" ></textarea> -->
         <td><textarea  id="{{'textarea'+ $index}}" type="textarea" placeholder="add your comment ........" ng-model="commentDetails[$index]"   style="width: auto; display: block;width:100%;"></textarea></td>
         <td><input id="{{'addUpdateBtn'+ $index}}" class="btn btn-info btn-lg" type="submit" name="addComment" value="Add" ng-click="addCommentBackAndFront($index , m.Id , commentDetails[$index] , customer , add_edits[$index] ) "></td>
        </tr>
      </tbody>
        </table>


        <div ng-show="menuItems.indexOf(m) < menuItems.length-1"><hr width="100%"></div>
      </div>



      <br>
    </div>

    <div class="col-lg-5" style="margin-left:-10px">
      <table class="table table-bordered" ng-show="orderItems.length > 0"  >
        <thead>
          <tr>
            <th id="thead">OrderItem</th>
            <th id="thead">Quantity</th>
            <th id="thead">Total Price</th>
            <th id="thead">Actions</th>
          </tr>
        </thead>
        <tbody ng-repeat="o in orderItems" >
          <tr>
            <td ng-bind="o.Name" id="thead"></td>
            <td ng-bind="o.Quantity" id="thead"></td>
            <td ng-bind="o.TotalPrice" id="thead"></td>
            <td ng-show="orderItems.length>0">
              <a title="Increase Quantity" id="creatNewCafeteria" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>
              <a title="Decrease Quantity" id="creatNewCafeteria" ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>
              <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="color:white;font-style:italic" class="btn">Remove This Item</a>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->
      <div><a style="font-style:italic;color:white;" class="btn" type="button" ng-href="/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId={{orderId}}"  ng-show="orderItems.length > 0"  target="_self"  >Checkout</a></div>
    </div>

  <hr width="80%">



  <h1>About This Category</h1><br>
  <h3>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</h3>
</div>


<script type="text/javascript">
  var redirect_to = <?php $file=__File__ ;echo "\"" .(string)(urlencode($file))."\""  ; ?>
</script>