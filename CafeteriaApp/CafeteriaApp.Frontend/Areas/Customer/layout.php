<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies
  $memcache = memcache_connect('localhost', 11211); 
  $Words = $memcache->get('words');
  $Languages= $memcache->get('languages');
  //$_SESSION["langId"]=2;
  $lang_id=$_SESSION["langId"];
  $orderId= $_SESSION['orderId'];
  //require_once("CafeteriaApp.Backend/functions.php");
?>

<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- <link rel="stylesheet" href="/CafeteriaApp.Frontend/css/bootstrap2.min.css" rel="stylesheet" type="text/css" > -->
      <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.eot" rel="font-woff">
      <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.svg" rel="font-woff">
      <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.ttf" rel="x-font-ttf">
      <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.woff" rel="font-woff">
      <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.woff2" rel="font-woff">
      <link href="/CafeteriaApp.Frontend/css/font face.css" rel="stylesheet">
      <!-- MetisMenu CSS -->
      <link href="/CafeteriaApp.Frontend/css/metisMenu.min.css" rel="stylesheet">
      <!-- DataTables CSS -->
      <link href="/CafeteriaApp.Frontend/css/dataTables.bootstrap.css" rel="stylesheet">
      <!-- DataTables Responsive CSS -->
      <link href="/CafeteriaApp.Frontend/css/dataTables.responsive.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet">
      <!-- Morris Charts CSS -->
      <link href="/CafeteriaApp.Frontend/css/morris.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="/CafeteriaApp.Frontend/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- Bootstrap Core CSS -->
      <!-- Latest compiled and minified CSS -->
      <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/CafeteriaApp.Frontend/css/bootstrap-select.min.css">
      <link href="/CafeteriaApp.Frontend/css/normalize.css" rel="stylesheet">
      <link href="/CafeteriaApp.Frontend/css/layout_style.css" rel="stylesheet" type="text/css">


      <script src="/CafeteriaApp.Frontend/javascript/jquery-3.2.1.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/bootstrap.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/angular-route.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-2.5.0.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-tpls-2.5.0.js"></script>
      <!-- <script src="/CafeteriaApp.Frontend/Scripts/libs/angular-route.js"></script> -->
      <script src="/CafeteriaApp.Frontend/javascript/angular-modal-service.js"></script>
      <!-- <script src="/CafeteriaApp.Frontend/Scripts/libs/knockout-3.4.2.js"></script> -->
      <script src="/CafeteriaApp.Frontend/javascript//alertify.min.js"></script>
      <!-- <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff" rel="font-woff">
      <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff2" rel="octet-stream">
      <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.ttf" rel="x-font-ttf"> -->
      <script src="/CafeteriaApp.Frontend/javascript/metisMenu.min.js"></script>
      <!-- DataTables JavaScript -->
      <script src="/CafeteriaApp.Frontend/javascript/jquery.dataTables.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/dataTables.bootstrap.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/dataTables.responsive.js"></script>
      <!-- Morris Charts JavaScript -->
      <script src="/CafeteriaApp.Frontend/javascript/raphael.min.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/morris.min.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="/CafeteriaApp.Frontend/javascript/sb-admin-2.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/order_service.js"></script>
      <script src="/CafeteriaApp.Frontend/javascript/location_provider.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="/CafeteriaApp.Frontend/javascript/bootstrap-select.min.js"></script>
    </head>
    <body style="background-image:url('/CafeteriaApp.Frontend/images/customer background image4.jpg')" ng-app="layout_app"
    ng-init="orderId=<?php echo $orderId ;?>;">
  
      <div ng-controller="Language_Order" ng-init=" languages=<?php echo htmlspecialchars($Languages);?>;selectedLang=languages[<?php echo ($lang_id-1);?>];orderId=<?php echo $orderId;?>" id="myctrl">
      


        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">

          <div class="container-fluid">
          <div class="row">
           

            <div class="navbar-header">
              <button class="navbar-toggle" data-toggle="collapse" data-target="#optionsNavbar" id="mybutton" style="float: left">

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

              </button>

            </div>

            <div id="optionsNavbar" class="navbar-collapse" >

              <ul id="left_ul" class="nav navbar-nav navbar-left">

                <li>

                  <a class="navbar-brand" href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php"><?php echo "{$Words['Home'][$lang_id]}"?></a>

                </li>

                <li>

                  <a class="navbar-brand" href="#"><?php echo "{$Words['Help'][$lang_id]}"?></a>

                </li>

                <li id="notification" title="Show Notifications" onclick="showNotifications()">

                    <?php

                      $length = 0;
                      if(!empty($_SESSION["notifications"]) && is_array($_SESSION["notifications"]))
                      { 
                        $ul="<ul style='color:blue;'>";
                        foreach ($_SESSION["notifications"] as  $value)
                        {
                          $length++;
                          $ul.= "<li>".$value[0]."</li>";
                        }

                        $ul.="</ul>";
                        $_SESSION["notifications"] =  $ul;
                      }
                      if ($length > 0)
                      {
                        echo " <img  src='/CafeteriaApp.Frontend/alarm-1.png' width='50' height='50' >";
                        echo "<label id='notifyLabel' style='color:blue;font-size:2em;'>{$length}</label>";
                      }
                      else
                      {
                        echo " <img  src='/CafeteriaApp.Frontend/alarm.png' width='55' height='55' >";
                      }

                    ?>

                  </li>

                <li class="inner">

                  <a class="navbar-brand" href="/CafeteriaApp.Frontend/Views/logout.php"><?php echo "{$Words['Log out'][$lang_id]}" ?></a>

                </li>

              </ul>

             </div>


       

       <ul id="right_ul">

           <li id="shoppingCart" title="Show Shopping Cart Items">

                    <div id="shoppingCart_Button">

                      <img src="/CafeteriaApp.Frontend/IconoCompraPaquetigos.png" style="width:100%;height:100%">

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

                          <tbody ng-repeat="o in orderItems">

                            <tr>

                              <td ng-bind="o.Name" id="thead"></td>

                              <td ng-bind="o.Quantity" id="thead"></td>

                              <td ng-bind="o.TotalPrice" id="thead"></td>

                              <td style="display:block;width:100%; padding: 0px;">

                                <ul  style="list-style: none; margin: 0px;padding: 0px">

                                  <li>

                                    <a title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a>

                                  </li>

                                  <li>

                                    <a  title="Decrease Quantity"  ng-click="decreaseQuantity(o)" class="btn"><i class="fa fa-minus"></i></a>

                                  </li>

                                  <li>

                                    <a title="Remove From Order" ng-click="deleteOrderItem(o)" style="font-weight:bold;" class="btn">X</a>

                                  </li>

                                </ul>

                              </td>

                            </tr>

                          </tbody>

                        </table> 

                        <div>

                          <a id="checkout" title="Check out this order" class="btn"  ng-href="/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId={{orderId}}&categoryId={{categoryId}}" ng-show="orderItems.length>0"  target="_self">Checkout</a>

                        </div>

                      </div>
                  
                    </div>

                  </li>



            <li id="languagesDropdown" >
              <select id="languages" class="selectpicker show-tick" select-picker ng-model="selectedLang"  ng-options="l.Name for l in languages" ng-change="changeLanguage(selectedLang.Id)" data-width="fit">

              </select>
                  </li>


             <li id="myProfile" style="display: inline-block">

                    <div class="btn-group">

                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      My Profile

                    </button>

                      <div   class="dropdown-menu" style="left:-70px;">
                              <div>
                        <a class="dropdown_item" href="/CafeteriaApp.Frontend/Areas/Customer/favorite items.php">My Favorites</a>

                        <a class="dropdown_item" href="#">Another action</a>

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
            </div>


            
            </nav>

      


            <!-- <div id="right_ul" style="margin-top: 40px"> -->

                  
                <!-- </div> -->
            <!-- <div> -->
            <!-- <nav class="navbar navbar-default navbar-fixed-top "> -->
              

              <!-- </nav> -->

            

         

        

     

    <script src="/CafeteriaApp.Frontend/javascript/window_resize.js"></script>  

    <script src="/CafeteriaApp.Frontend/javascript/layout.js"></script>