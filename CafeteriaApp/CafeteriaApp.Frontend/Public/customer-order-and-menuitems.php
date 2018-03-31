<div class="container">

  <div style="text-align: center">

    <h1 style="margin-bottom: 20px;border-bottom: 3px solid orange">Menu</h1>

      <div class="popup">

        <span class="popuptext" id="myPopup">A Simple Popup!</span>

      </div>

  </div>

  <div class="row" ng-controller="getMenuItemsAndCustomerOrder" ng-init="customer='<?php echo $_SESSION['userName']; ?>'" >

    <div class="col-lg-5">

      <div ng-repeat="m in menuItems" style="width: 90%;margin-left: 40px">

        <h1 style="color: #4CAF50;font-family: FontAwesome" ng-bind="m.Name" class="menu-name"></h1>
                
        <a id="{{'favorites' + m.Id}}" title="add to favorites" style="color: red;float: right" ng-click="toggleFavoriteItem(m.Id)" class="btn btn-info btn-lg">

          <span class="glyphicon glyphicon-heart"></span>

        </a>

        <div class="addToOrder">

          <a title="Add To Order" ng-click="addToOrder(m)" class="btn btn-circle" ><i class="fa fa-plus"></i></a>

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

        <a title="Show/Hide Comments" style="color: blue;float: right" ng-click="toggleMenuItemComments($index, m.Id)" class="btn btn-lg comments">

          <span>{{ ShowHides[$index] ?'Hide Comments':'Show Comments'}}</span>

        </a>

        <div style="color: white;font-style: italic">Name :  

          <span ng-bind="m.Name" style="color: white"></span>

        </div>

        <div style="color: white;font-style: italic">Price :  

          <span ng-bind="m.Price" style="color: white"></span>

        </div>

        <div style="color: white;font-style: italic">Rating :  

          <span ng-bind="m.Rating" style="color: white"></span>

          <span> from </span>

          <span ng-bind="m.RatingUsersNo" style="color: white"></span>

          <span>  user(s)</span>

        </div>

        <div style="color: white;font-style: italic">Description :  

          <span ng-bind="m.Description" style="color: white"></span>

        </div>
          
        <!-- Comments -->

        <table class="blueTable" id="{{'comments' + m.Id}}" ng-if="data.ShowHides[$index]">

          <caption style="color: blue;font-weight: bold">{{m.Name}} Comments</caption>
         
          <tbody>

            <tr ng-repeat="comm in data.comments[$index]">

              <td>{{comm.UserName}}</td>

              <td>{{comm.Date}}</td>
         
              <td><p>{{comm.Details}} </p> </td>

              <td ng-if="checkEditAndRemove( comm.Id, menuItems.indexOf(m) )">

                <a style="cursor: pointer" ng-click="editComment( $index, menuItems.indexOf(m) )">edit</a> &nbsp;

                <a ng-click="deleteComment( comm.Id, $index, menuItems.indexOf(m) )"  style="cursor: pointer">remove</a>

              </td>

            </tr>

          </tbody>

          <tbody>

            <tr>   
            <!-- <textarea ng-KeyPress="$event.keyCode ==13 ? addCommentBackAndFront(m.Id,commentDetails,customer) :null" ></textarea> -->

              <td>

                <textarea id="{{'textarea' + $index}}" type="textarea" placeholder="add your comment ........" ng-model="data.commentDetails[$index]" style="width: auto;display: block;width: 100%"></textarea>

              </td>

              <td>

                <input id="{{'addUpdateBtn' + $index}}" class="btn btn-info btn-lg" type="submit" name="addComment" value="Add" ng-click="addCommentBackAndFront($index, m.Id, data.commentDetails[$index], customer, data.add_edits[$index])">

              </td>

            </tr>

          </tbody>

        </table>

        <div ng-cloak ng-show="menuItems.indexOf(m) < menuItems.length - 1"><hr width="100%"></div>

      </div>

      <br>

    </div>

    <div class="col-lg-5" style="margin: 10px">

      <table class="table table-bordered" ng-cloak ng-show="orderItems.length > 0">

        <thead>

          <tr>

            <th id="thead">OrderItem</th>

            <th id="thead">Quantity</th>

            <th id="thead">Total Price</th>

            <th id="thead">Actions</th>

          </tr>

        </thead>

        <tbody ng-repeat="o in orderItems">

          <tr>

            <td ng-bind="o.Name" id="thead"></td>

            <td ng-bind="o.Quantity" id="thead"></td>

            <td ng-bind="o.TotalPrice" id="thead"></td>

            <td ng-cloak ng-show="orderItems.length > 0">

              <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>

              <a title="Decrease Quantity" ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>

              <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="color: white;font-style: italic" class="btn">Remove This Item</a>

            </td>

          </tr>

        </tbody>

      </table>

      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->

      <div style="align-content: center;text-align: center">

        <a style="font-style: italic;color: white" class="btn btn-info btn-lg " ng-href="../../checkout.php?orderId={{orderId}}&categoryId={{categoryId}}" ng-cloak ng-show="orderItems.length > 0 && roleid == false" target="_self">Checkout</a>

        <a style="font-style: italic;color: white" class="btn btn-info btn-lg" href="../../../Cashier/Order/Views/show_and_hide_orders.php" ng-cloak ng-show="roleid == true" target="_self">Return To Orders</a>

      </div>

    </div>