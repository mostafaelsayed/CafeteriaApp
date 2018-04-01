<?php require_once(__DIR__.'/../CafeteriaApp.Backend/session.php'); // must be first as it uses cookies
  $memcache = memcache_connect('localhost', 11211); 
  $Words = $memcache->get('words');
  $Languages = $memcache->get('languages');
  $lang_id = $_SESSION['langId'];
  $orderId = $_SESSION['orderId'];

?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="text/css" href="/CafeteriaApp/CafeteriaApp/favicon.ico">
    
    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-select.min.css">
    <link href="../css/normalize.css" rel="stylesheet">
    <link href="../css/layout_style.css" rel="stylesheet" type="text/css">

    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/angular.min.js"></script>
    <!-- <script src="../javascript/alertify.js"></script> -->
    <script src="../js/customer_and_cashier_order.js"></script>
    
    <script src="../js/metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>

    <script src="../js/location_provider.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="../js/bootstrap-select.min.js"></script>
    
  </head>

  <body style="background-image: url('../images/customer background image4.jpg')" ng-app="layout_app"
  ng-init="orderId = <?= $orderId;?>;" ng-cloak>

    <div ng-controller="Language_Order" ng-init="languages = <?= htmlspecialchars($Languages);?>;selectedLang = languages[<?= ($lang_id - 1);?>];orderId = <?= $orderId;?>" id="myctrl">

      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-fixed-top">

        <div class="container-fluid">

            <div class="navbar-header">

              <button class="navbar-toggle" data-toggle="collapse" data-target="#optionsNavbar" id="mybutton" style="float: left">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

            </div>
            <div id="optionsNavbar" class="navbar-collapse">

              <ul id="left_ul" class="nav navbar-nav navbar-left">

                <li>
                  <a class="navbar-brand" href='<?=__DIR__.'/Public/showing cafeterias.php';?>''><?= "{$Words['Home'][$lang_id]}"?></a>
                </li>

                <li>
                  <a class="navbar-brand" href="#"><?= "{$Words['Help'][$lang_id]}"?></a>
                </li>

                <li id="notification" title="Show Notifications" onclick="showNotifications()">

                  <?php $length = count($_SESSION['notifications']); ?>
                 
                  <div class="btn-group">

                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 90px; height: 50px;padding: 0px;background-color:transparent;border-color: transparent">

                    <?php
                      if ($length > 0) {
                        echo "<img src='../images/alarm-1.png' style='width:40px; height:40px;'>
                        <label id='notifyLabel' style='color: blue;font-size: 2em'>{$length}</label>";
                      }
                      else {
                        echo "<img src='../images/alarm.png' style='width:40px; height:40px;'>";
                      }

                      if ( !empty($_SESSION['notifications']) && is_array($_SESSION['notifications']) ) {
                        $ul = "<ul style='color: blue;'>";

                        foreach ($_SESSION["notifications"] as $value) {
                          $ul .= "<li><h4>" . $value . "</h4></li>";
                        }

                        $ul .= "</ul>";
                      }
                    ?>

                  </button>
                  <div class="dropdown-menu" style="left: -70px;padding: 5px;width: 300px;background-color: #FFC806">
                
                    <?= isset($ul)? $ul : "<h5>No Notifications</h5>"; ?>
                   
                  </div>

                </div>

              </li>

              <li class="inner">
                <a class="navbar-brand"  href="../logout.php"><?= "{$Words['Log out'][$lang_id]}" ?>
                </a>
              </li>

            </ul>

          </div>

          <ul id="right_ul">
            <li id="shoppingCart" title="Show Shopping Cart Items">
              <div id="shoppingCart_Button">
                <img src="../IconoCompraPaquetigos.png" style="width: 100%;height: 100%">
              </div>

              <div id="shoppingCartDetails">

                <h3 id="OrderItemsHeader">Order Items</h3>

                  <div id="OrderContents">
         
                    <table id="orderTable" class="table table-bordered" ng-show="orderItems.length > 0">

                      <thead>

                        <tr>

                          <th id="thead">OrderItem</th>

                          <th id="thead">Quantity</th>

                          <th id="thead">Total Price</th>

                          <th id="thead">Actions</th>

                        </tr>

                      </thead>

                      <tbody ng-if="orderItems.length>0" ng-repeat="o in orderItems">

                        <tr>

                          <td ng-bind="o.Name" id="thead"></td>

                          <td ng-bind="o.Quantity" id="thead"></td>

                          <td ng-bind="o.TotalPrice" id="thead"></td>

                          <td style="display: block;width: 100%; padding: 0px">

                            <ul style="list-style: none; margin: 0px;padding: 0px">

                              <li>

                                <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>

                              </li>

                              <li>

                                <a title="Decrease Quantity" ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>

                              </li>

                              <li>

                                <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="font-weight: bold" class="btn">X</a>

                              </li>

                            </ul>

                          </td>

                        </tr>

                      </tbody>

                    </table> 

                    <div>
                      <a id="checkout" title="Check out this order" class="btn" ng-href="../Areas/Customer/checkout.php?orderId={{orderId}}&categoryId={{categoryId}}" ng-show="orderItems.length > 0"  >
                      Checkout
                      </a>
                    </div>
                  </div>
                </div>
              </li>

              <li id="languagesDropdown">
                <select id="languages" class="selectpicker show-tick" select-picker ng-model="selectedLang" ng-options="l.Name for l in languages" ng-change="changeLanguage(selectedLang.Id)" data-width="fit">
                </select>
              </li>

              <li id="myProfile" style="display: inline-block">
                <div class="btn-group">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Profile <span class="glyphicon glyphicon-user"></span>
                  </button>

                  <div class="dropdown-menu" style="left: -70px">

                    <div>

                      <a class="dropdown_item" href="../Customer/favorite items.php" >My Favorites</a>

                      <a class="dropdown_item" href="#">Change Password</a>

                      <a class="dropdown_item" href="#">Something else here</a>

                    </div>

                    <hr>

                    <div>

                      <a class="dropdown_item" href="#">Separated link</a>

                    </div>

                  </div>

                </div>

              </li>

            </ul>

        </div>

      </nav>

      <script type="text/javascript">
        function showNotifications() {
          $('#notifyLabel').html('');
          $("#notifyme").slideToggle("slow");
        }
      </script>

      <script src="../js/layout.js"></script>