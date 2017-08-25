<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  require_once('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>
<title>MenuItems</title>


<script src="/CafeteriaApp.Frontend/javascript/showing menuitems of a category and customer order.js"></script>
<link type="text/css"  href="/CafeteriaApp.Frontend/css/normalize.css" rel="stylesheet">
<link type="text/css" href="/CafeteriaApp.Frontend/css/customer styles.css" rel="stylesheet">

<style type="text/css">
  


.row .col-lg-5  table{

border : 1px solid blue;
 width : 100%;
}

.row .col-lg-5 .blueTable tr:hover
 {
  background-color: #444441;
text-shadow: 0 0 20px #952;
 transition: all .3s;
 }

.row .col-lg-5 .blueTable>tr{/*first tr child in table */
margin: 10px;
/*color: white;*/
}

.row .col-lg-5 .blueTable td{
text-align:center;
margin: 10px;
color: white;
 display:block;

}

.row .col-lg-5 .blueTable td>a{

text-decoration: none;
}

.row .col-lg-5 .addToOrder a:hover{

 background-color: #444441;
 transition: all .2s;

}

.row .col-lg-5 .addToOrder  a {
color:white;
float:right;
margin-top:-40px
}

.bottom a{
color: white;
cursor: pointer;
text-decoration: none;
}

.about{
  display: none;
}



hr {
  margin: 20px;
  border: none;
  border-bottom: thin solid rgba(255,255,255,.1);
}


.row .col-lg-5 div.stars {
  width: 270px;
  display: inline-block;
}

.row .col-lg-5 input.star { 
  display: none;
   }

.row .col-lg-5 label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

.row .col-lg-5 input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

.row .col-lg-5 input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

.row .col-lg-5 input.star-1:checked ~ label.star:before {
 color: #F62;
  }

.row .col-lg-5 label.star:hover {
 transform: rotate(-15deg) scale(1.3); 
cursor: pointer;
}

.row .col-lg-5 label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}

.btn.btn-lg.comments:hover{
  background-color: #278376;
    font-size: 20px;
 transition: all .2s;

}
</style>

<h1 style="margin: 0 auto; margin-top:220.5px;border-bottom:2px solid white ;width:20%" >Menu</h1>

<div class="row"  ng-controller="getMenuItemsAndCustomerOrder" ng-init="customer='<?php echo $_SESSION['userName']; ?>'" >

    <div class="col-lg-5">
      <div ng-repeat="m in menuItems" style="width:90%;margin-left:40px">
        <h1 style="color: #4CAF50;font-family:FontAwesome ;" ng-bind="m.Name" class="menu-name" ></h1>
       

        <!-- <h2 ng-show="ShowCallsInNGRepeat()"></h2> -->
       
        <a id="{{'favorites'+m.Id}}" title="add to favorites" style="color:red;float:right;" ng-click="toggleFavoriteItem(m.Id)" class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-heart"></span></a>


       <div class="addToOrder">
        <a  title="Add To Order"  ng-click="addToOrder(m)" class="btn btn-circle" ><i class="fa fa-plus"></i></a>
        </div>

        <!-- Stars Rating -->

  <div   class="stars">
    <form >
      <input ng-change='addRatingOrUpdate(m.Id,ItemRating[$index])' class="star star-5" id="star-5-{{m.Id}}" type="radio" name="star" value="5"  ng-model="ItemRating[$index]"  />
      <label  class="star star-5" for="star-5-{{m.Id}}"></label>
      <input ng-change='addRatingOrUpdate(m.Id,ItemRating[$index])' class="star star-4" id="star-4-{{m.Id}}" type="radio" name="star"  value="4" ng-model="ItemRating[$index]" />
      <label class="star star-4" for="star-4-{{m.Id}}"></label>
      <input ng-change='addRatingOrUpdate(m.Id,ItemRating[$index])' class="star star-3" id="star-3-{{m.Id}}" type="radio" name="star"  value="3" ng-model="ItemRating[$index]" />
      <label class="star star-3" for="star-3-{{m.Id}}"></label>
      <input ng-change='addRatingOrUpdate(m.Id,ItemRating[$index])' class="star star-2" id="star-2-{{m.Id}}" type="radio" name="star"  value="2" ng-model="ItemRating[$index]" />
      <label class="star star-2" for="star-2-{{m.Id}}"></label>
      <input ng-change='addRatingOrUpdate(m.Id,ItemRating[$index])' class="star star-1" id="star-1-{{m.Id}}" type="radio" name="star"  value="1" ng-model="ItemRating[$index]" />
      <label class="star star-1" for="star-1-{{m.Id}}"></label>
    </form>
  </div>



       

     <a  title="Show/Hide Comments" style="color:blue;float:right;" ng-click="toggleMenuItemComments($index,m.Id)" class="btn btn-lg comments">
          <span >{{ ShowHides[$index] ?'Hide Comments':'Show Comments'}}</span></a>


        <div style="color:white;font-style:italic">Name :  <span ng-bind="m.Name" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Price :  <span ng-bind="m.Price" style="color:white"></span></div>
        <div style="color:white;font-style:italic">Rating :  <span ng-bind="m.Rating" style="color:white"></span><span> from </span><span ng-bind="m. RatingUsersNo" style="color:white"></span><span>  user(s)</span></div>
        <div style="color:white;font-style:italic">Description :  <span ng-bind="m.Description" style="color:white"></span></div>
        
                  <!-- Comments -->

        <table class="blueTable" id="{{'comments'+m.Id}}" ng-if="ShowHides[$index]"  >
          <caption style="color:blue;font-weight:bold;">{{m.Name}} Comments</caption>
         
          <tbody id="" >
        <tr ng-repeat="comm in comments[$index]">
          <td>{{comm.UserName}}</td>
          <td>{{comm.Date}}</td>
         
          <td><p>{{comm.Details}} </p> </td>

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
              <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>
              <a title="Decrease Quantity"  ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>
              <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="color:white;font-style:italic" class="btn">Remove This Item</a>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->
      <div><a style="font-style:italic;color:white;" class="btn" type="button" ng-href="/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId={{orderId}}&categoryId={{categoryId}}"  ng-show="orderItems.length > 0"  target="_self"  >Checkout</a></div>
    </div>

          <hr width="90%">

             <div class="bottom" style="margin:0 auto;text-align:center;">
                  <a target="_self" href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing categories of a cafeteria.php?id={{cafeteriaId}}" >Back</a>
                  <br><br>
                  <a  onclick="slideAbout()" >About This category</a>
                </div>

  <div class="about" style="margin:0 auto;text-align:center;color:white;">
    <h1>About This Category</h1>
    <p>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</p>
    </div>

</div>


<script type="text/javascript">
  var redirect_to = <?php $file=__File__ ;echo "\"" .(string)(urlencode($file))."\""  ; ?>

  function slideAbout() {
  $(".about").slideToggle("slow");

  }



</script>