<?php 
require_once(__DIR__ . '/../CafeteriaApp.Backend/session.php'); // must be first as it uses cookies
require(__DIR__ . '/../CafeteriaApp.Backend/functions.php');

checkGetParams();

// $selected_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
// $direction     = $selected_lang == 'ar' ? 'rtl' : 'ltr';

// if ($selected_lang == 'ar') {
//     $Words = json_decode(file_get_contents(__DIR__ . '/langs/Public/ar.json'), true);
// } else {
//     $Words = json_decode(file_get_contents(__DIR__ . '/langs/Public/en.json'), true);
// }
// $requeted_file = str_replace('.php', '', basename($_SERVER['PHP_SELF']));

// $Words = array_merge($Words['header'], $Words['footer'], $Words[$requeted_file]);

$orderId = isset($_SESSION['orderId']) ? $_SESSION['orderId'] : 0 ;
$userImage = isset($_SESSION['image']) ? $_SESSION['image'] : 'no Image' ;
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : 'anonymous' ;
$selected_lang ='en';
?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="text/css" href="/CafeteriaApp/CafeteriaApp/favicon.ico">
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/normalize.css" rel="stylesheet"/>
    <!-- MetisMenu CSS -->
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/metisMenu.min.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet"/>
    <!-- Custom Fonts -->
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="../css/bootstrap-select.min.css"> -->
    <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/layout.css" rel="stylesheet" type="text/css"/>

  </head>

  <body style="background-color:#ECD297;" ng-app="layout_app"
  ng-init="orderId = <?= $orderId;?>;" ng-cloak>

    <div ng-controller="Language_Order" ng-init="languages=['English', 'Arabic'];selectedLang = 1;orderId = <?= $orderId;?>" id="myctrl">

      <!-- Navigation -->
      <nav class="navbar navbar-fixed-top w3-animate-top">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header" style="display:inline;!important">

          <img id="logo" style="width:60px;height:60px;" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/logo_main.png">

        </div>

        <div class="collapse navbar-collapse" id="myNavbar">

          <ul class="nav navbar-nav">

            <li>

              <a href='/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php'>Home</a>

            </li>

            <li>

              <a href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/help.php">Help</a>

            </li>

            <li>

              <a id="contact" href="ssss.php">Contact us</a>

            </li>

            <li role="separator" class="divider"></li>

          </ul>

          <ul class="nav navbar-nav navbar-right">

            <li ng-if='orderId' id="shoppingCart" title="Show Shopping Cart Items">

              <img id="shoppingCart-btn" src="../images/icons/cart-layout.png" />

              <div id="shoppingCartDetails">

                <h3 id="OrderItemsHeader">Order Items</h3>

                <h5 ng-show="orderItems.length == 0">Empty Cart !</h5>

                <div id="OrderContents" ng-show="orderItems.length > 0">

                  <table id="orderTable" class="table table-bordered">

                    <thead>

                      <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                      </tr>

                    </thead>

                    <tbody ng-if="orderItems.length > 0" ng-repeat="o in orderItems">

                      <tr>

                        <td ng-bind="o.Name"></td>

                        <td ng-bind="o.Quantity"></td>

                        <td ng-bind="o.TotalPrice"></td>

                        <td style="display: block;width: 100%; padding: 0px">

                          <ul style="list-style: none; margin: 0px;padding: 0px">

                            <li>

                              <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn">

                                <i class="fa fa-plus"></i>

                              </a>

                            </li>

                            <li>

                              <a title="Decrease Quantity" ng-click="decreaseQuantity(o)" class="btn">

                                <i class="fa fa-minus"></i>

                              </a>

                            </li>

                            <li>

                              <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="font-weight: bold" class="btn">X</a>

                            </li>

                          </ul>

                        </td>

                      </tr>

                    </tbody>

                  </table> 

                  <div id="cart_checkout">

                    <a class="btn checkout" title="Check out this order" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/checkout.php?orderId={{orderId}}">

                      Checkout <span class="glyphicon glyphicon-usd"></span>

                    </a>

                  </div>

                </div>

              </div>

            </li>

            <li id="notification" title="Show Notifications" onclick="toggleNotifications()">

              <?php $length = count($_SESSION['notifications']); ?>

              <button id="notify-btn" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <?php
                  if ($length > 0) {
                    echo "<img src='../images/alarm-1.png' style='width:40px; height:40px;'/>
                      <label id='notifyLabel' style='color: blue;font-size: 2em'>{$length}</label>";
                  }
                  else {
                    echo "<img src='../images/alarm.png' style='width:40px; height:40px;'/>";
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

              <div class="dropdown-menu" style="left:-100px;top:35px;width:300px;background-color: #FFC806">
                
                <?= isset($ul)? $ul : "<h5>No Notifications</h5>"; ?>
                   
              </div>

            </li>

            <li id="languagesDropdown" class="btn-sm">

              <div class="dropdown">

                <button class="btn language dropdown-toggle" type="button" data-toggle="dropdown">

                  <span><?=$selected_lang == 'en' ? "En" : "Ar"?></span>

                  <i class="glyphicon glyphicon-chevron-down"></i>

                </button>

                <ul class="dropdown-menu dropdown-langs">

                  <li class="dropdown-item">

                    <span class="glyphicon glyphicon-ok check-mark"></span>

                    <a onclick="changeUserLang(1);" href="<?=count($_GET) > 1 ? str_replace('lang=en', 'lang=ar', $_SERVER['REQUEST_URI']) : $_SERVER['PHP_SELF'] . "?lang=ar";?>"><img src="/Shipping/images/header/Egypt-Flag.png" width="20" alt=""> Arabic
                    </a>

                  </li>

                  <!-- <li class="divider" style="margin:4px 0"></li> -->

                  <li class="dropdown-item">

                    <span></span>

                    <a id="Eng" onclick="changeUserLang(0);" href="<?=count($_GET) > 1 ? str_replace('lang=ar', 'lang=en', $_SERVER['REQUEST_URI']) : $_SERVER['PHP_SELF'] . "?lang=en";?>"><img src="/Shipping/images/header/United-Kingdom-flag.png" width="20" alt=""> English

                    </a>

                  </li>

                </ul>

              </div>

            </li>

            <?php if ( isset($_SESSION['userId']) ) { ?>

              <li id="myProfile" class="btn-sm">

                <div class="btn-group">

                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Profile

                    <span class="glyphicon glyphicon-user"></span>

                  </button>

                  <div class="dropdown-menu" style="left: -70px">

                    <a class="dropdown_item" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/favorite items.php"> My Favorites</a>

                    <a class="dropdown_item" href="#">Change Info</a>

                    <a class="dropdown_item" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/change_password.php">Change Password</a>

                    <hr>

                    <a class="dropdown_item" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/logout.php">Log out

                    </a>

                  </div>

                </div>

              </li>

            <?php } else { ?>

              <li style="margin-left: 70px;">

                <a href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/login.php" class="btn btn-info" style="font-size: 2rem;padding-top: 5px;">

                  Login

                  <span class="glyphicon glyphicon-log-in"></span>

                  </a>

                </li>

            <?php } ?>

          </ul>

        </div>

      </nav>

    </div>

    <?php 
      if ( !isset($_SESSION['userId']) ) {
        echo "<h1>login <a href='/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/login.php'>here</a> so you can order food, rate items, add comments and more ... </h1>";
      }
    ?> 

    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/jquery-3.2.1.min.js"></script>
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/bootstrap.min.js"></script>
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/angular.min.js"></script>
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify.js"></script>
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/customer_and_cashier_order.js"></script>
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/sb-admin-2.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="../js/bootstrap-select.min.js"></script> -->
    <script type="text/javascript">
      // function toggleNotifications() {
      //   $('#notifyLabel').html('');
      //   $("#notifyme").slideToggle("slow");
      // }

      // $(document).click(function (event) {
      //     var clickover = $(event.target);
      //     var $navbar = $(".navbar-collapse");               
      //     var _opened = $navbar.hasClass("in");

      //     // check if it's open and we clicked outside the toggle button
      //     if (_opened === true && !clickover.hasClass("navbar-toggle")) {      
      //         $navbar.collapse('hide');
      //     }
      // });


      // $.urlParam = function(name){
      // var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      //   if (results==null){
      //      return null;
      //   } else {
      //      return decodeURI(results[1]) || 0;
      //   }
      // }
    </script>

    <script type="text/javascript">
      $.urlParam = function(name) {
          var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

          if (results == null) {
              return null;
          } else {
              return decodeURI(results[1]) || 0;
          }
      }
    </script>

    <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/layout.js"></script>
