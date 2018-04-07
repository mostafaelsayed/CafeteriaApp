<div class="container">

  <div style="text-align: center">

    <h1 style="padding-bottom:20px;margin-bottom:20px;border-bottom: 3px solid #31B0D5;font-family: fontAwsome;font-size:4rem;">
      <?=$_GET['categoryName']?>
      </h1>

      <div class="popup">
        <span class="popuptext" id="myPopup">A Simple Popup!</span>
      </div>

  </div>

  <div class="row" ng-controller="getMenuItemsAndCustomerOrder" ng-init="customer='<?= $userName; ?>';userImage='<?=$userImage;?>';" >

    <div class="col-md-6 w3-animate-bottom">
      <div ng-repeat="m in menuItems" style="width: 90%;margin-left: 40px">

        <h1 ng-bind="m.Name" class="menu-name"></h1>
         <?php if(isset($_SESSION['userId'])) { ?>     
        <a id="{{'favorites' + m.Id}}" class="btn btn-info btn-favorite" title="add to favorites" ng-click="toggleFavoriteItem(m.Id)" >
          <span class="glyphicon glyphicon-heart"></span>
        </a>

        <div class="addToOrder">
          <a style="font-size:2rem;text-shadow:2px 2px 10px;" title="Add To Order" ng-click="addToOrder(m)" class="btn btn-circle" ><i class="fa fa-plus"></i>
          </a>
        </div>

        <!-- Stars Rating -->
        <div class="stars">
          <form>
            <input ng-change='addRatingOrUpdate(m.Id, data.ItemRating[$index])' class="star star-5" id="star-5-{{m.Id}}" type="radio" name="star" value="5" ng-model="data.ItemRating[$index]" />
            <label class="star star-5" for="star-5-{{m.Id}}"></label>
            <input ng-change='addRatingOrUpdate(m.Id, data.ItemRating[$index])' class="star star-4" id="star-4-{{m.Id}}" type="radio" name="star" value="4" ng-model="data.ItemRating[$index]" />
            <label class="star star-4" for="star-4-{{m.Id}}"></label>
            <input ng-change='addRatingOrUpdate(m.Id, data.ItemRating[$index])' class="star star-3" id="star-3-{{m.Id}}" type="radio" name="star" value="3" ng-model="data.ItemRating[$index]" />
            <label class="star star-3" for="star-3-{{m.Id}}"></label>
            <input ng-change='addRatingOrUpdate(m.Id, data.ItemRating[$index])' class="star star-2" id="star-2-{{m.Id}}" type="radio" name="star" value="2" ng-model="data.ItemRating[$index]" />
            <label class="star star-2" for="star-2-{{m.Id}}"></label>
            <input ng-change='addRatingOrUpdate(m.Id, data.ItemRating[$index])' class="star star-1" id="star-1-{{m.Id}}" type="radio" name="star" value="1" ng-model="data.ItemRating[$index]" />
            <label class="star star-1" for="star-1-{{m.Id}}"></label>
          </form>
        </div>
        <?php } ?>
        <a title="Show/Hide Comments" style="color:orange;float:right" ng-click="toggleMenuItemComments($index, m.Id)" class="btn btn-lg btn-comments">
          <span style="color:orange;" class="glyphicon glyphicon-comment"></span>
        </a>
        <div style="color: white;font-style: italic">
          <div>Price : $ <span ng-bind="m.Price" style="color: white"></span>
          </div>

          <div>Rating :  
            <span ng-bind="m.Rating" ></span>
            <span> from </span>
            <span ng-bind="m.RatingUsersNo" ></span>
            <span>  user(s)</span>
          </div>
          <div>calories: 35 kcl</div>
          <div>Description : ingredients,  
            <span ng-bind="m.Description" style="color: white"></span>
          </div>

        </div>
        <!-- Comments -->

        <table class="comments" id="{{'comments' + m.Id}}" ng-if="data.ShowHides[$index]">
          
          <tbody>
            <tr ng-repeat="comm in data.comments[$index]">
              <td>
                <img src="{{comm.Image}}" style="width:50px;height:50px;border-radius:50%;box-sizing:border-box;">
                &nbsp;
                {{comm.UserName}}
              </td>
              <td>{{comm.Date}}</td>
              <td><p>{{comm.Details}} </p></td>
              <td ng-if="checkEditAndRemove( comm.Id, menuItems.indexOf(m) )">
                <a style="cursor: pointer" ng-click="editComment( $index, menuItems.indexOf(m) )">edit</a> &nbsp;
                <a ng-click="deleteComment( comm.Id, $index, menuItems.indexOf(m) )"  style="cursor: pointer">remove</a>
              </td>
            </tr>
          </tbody>
          <?php if(isset($_SESSION['userId'])) {?>
          <tbody>
            <tr>
            <!-- <textarea ng-KeyPress="$event.keyCode ==13 ? addCommentBackAndFront(m.Id,commentDetails,customer) :null" ></textarea> -->

              <td colspan="2">
                <textarea id="{{'textarea' + $index}}" type="textarea" placeholder="add your comment ........" ng-model="data.commentDetails[$index]" style="display:block;width: 100%;border-radius:10px;">
                </textarea>

              </td>
              <td> 
                <input id="{{'addUpdateBtn' + $index}}" style="display:block;margin-left:10px;" class="btn btn-info" type="submit" name="addComment" value="Add" ng-click="addCommentBackAndFront($index, m.Id, data.commentDetails[$index], customer, data.add_edits[$index], userImage)"/>
              </td>

            </tr>

          </tbody>
          <?php }?>

        </table>

        <div ng-cloak ng-show="menuItems.indexOf(m) < menuItems.length - 1"><hr width="100%"></div>

      </div>

      <br>

    </div>
    <?php if(isset($_SESSION['userId'])) { ?>
    <div id="openOrder" class="col-md-4 w3-animate-zoom" style="position:fixed;right:0;bottom:0;">

      <div>
      <label style="color:white;margin-left:10px;font-size:1.5rem">Order {{orderId}}
      </label>
      
        <a  class="btn checkout pull-right" style="margin-bottom:5px;" ng-href="../Customer/checkout.php?orderId={{orderId}}" ng-cloak ng-show="orderItems.length > 0 && roleid == false" target="_self">
          Checkout 
          <span class="glyphicon glyphicon-usd"></span>
        </a>
        <a onclick="$('#openOrder').fadeOut();" class="pull-right btn btn-info btn-circle" style="margin:0 10px 0 0;padding:5px 0; "  href="javascript:;"><span class="glyphicon glyphicon-arrow-down"></span></a>
        <a style="font-style:italic;color: white" class="btn btn-info btn-lg" href="../../../Cashier/Order/Views/show_and_hide_orders.php" ng-cloak ng-show="roleid == true" target="_self">
          Return To Orders
        </a>
      </div>

      <table class="table order" ng-cloak ng-show="orderItems.length > 0">
        <thead>
          <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th></th>
          </tr>
        </thead>

        <tbody ng-repeat="o in orderItems">

          <tr>
            <td style="color:#58AF50;font-size:2rem;font-family:FontAwesome" ng-bind="o.Name" ></td>
            <td style="font-size:2rem" ng-bind="o.Quantity" ></td>
            <td ng-bind="o.TotalPrice" ></td>
            <td ng-cloak ng-show="orderItems.length > 0">
              <div style="width:100px;border-radius:50%;border:2px solid orange;text-align:center;">
              <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>
              <a title="Decrease Quantity" ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>
              </div>
              <a class="btn removeItem" title="Remove From Order" ng-click="deleteOrderItem(o)" style="font-style: italic" >Remove Item
              </a>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->

    </div>

    <?php } ?>