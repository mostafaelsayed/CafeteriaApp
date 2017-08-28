<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
 //require_once("CafeteriaApp.Backend/functions.php"); 
?>

<!DOCTYPE html >
<html  > 

<?php $memcache = memcache_connect('localhost', 11211); 
      $Words = $memcache->get('words');
      $Languages= $memcache->get('languages');
      //$_SESSION["langId"]=2;
      $lang_id=$_SESSION["langId"];
     $orderId= $_SESSION['orderId'];
?>
<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--     <link rel="stylesheet" href="/CafeteriaApp.Frontend/css/bootstrap2.min.css" rel="stylesheet" type="text/css" >
 -->
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

  <!-- <link href="/CafeteriaApp.Frontend/css/layout_style.css" rel="stylesheet" type="text/css"> -->


  <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="/CafeteriaApp.Frontend/css/bootstrap-select.min.css">

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
    <script src="/CafeteriaApp.Frontend/javascript/myapp.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="/CafeteriaApp.Frontend/javascript/bootstrap-select.min.js"></script>




<style type="text/css">

#wrapper{
position: static;

}
nav{
  height: 57px;
  background-image:  url('/CafeteriaApp.Frontend/images/customer background image4.jpg');

}


#left_ul >li>a{
 color: blue;
}

#right_ul>li>a {
 color: #FFAD33; 
 position: absolute;
 padding-top: 0px;
}

#right_ul {
  margin-left: 30px;

}


#left_ul>li>a:hover
{
  border-radius: 5px;
background-color: #6A8500;
color: black;
transform: rotate(-15deg) scale(1.3);
transition: all 0.3s;
}

.navbar-default.navbar-nav>li>a:active
{
  color: yellow;
}

#header {
  text-align:center;
  margin-top:70px;
  color: white;
  font-style: italic;
}

#notification{

margin-right:50px;
cursor:pointer;
width: 55px;
}

#notification:hover{
transform: rotate(15deg) scale(1.3);
}

#myProfile{
  margin-right: 200px;
width : 100px;
height : 70px;
padding-bottom : 0px;
}

#shoppingCart{
margin-right: 50px; 
  cursor:pointer;
  width: 50px;
overflow: visible;
}

#shoppingCart_Button:hover{
transform: rotate(15deg) ;
border: 10px solid #E9EA99;
border-radius: 28px;
padding: 0px;
transition: all 0.3s;
}


#shoppingCartDetails {
    display:none;
    width:350px;
    position:absolute;
    top:58px;
    left:10px;
   
    background:#E9EA99;
    border:solid 1px rgba(100, 100, 100, .20);
    -webkit-box-shadow:0 3px 8px rgba(0, 0, 0, .20);
    z-index: 1;
    text-align: center;
    border-radius: 10px;
     cursor: auto;
}

#OrderItemsHeader{

  background-color:#FFAD33;
  color: #0E2F3E;
  margin:0;
  padding:10px 0px 10px 0px;
  font-weight:bold;
  border-radius: 10px;
}

#OrderContents{

  height:300px;
  overflow: auto;
}

#orderTable{
  color: #891C86;
  font-weight: bold;
  /*display: block;*/
   border: 2px solid #5F5F5F;
  border-collapse: collapse;
  width: 100%;
  border-radius: 10px;
}


#orderTable th{
   border: 1px solid #5F5F5F;
  border-collapse: collapse;

}
#orderTable tbody{
  border-collapse: collapse;
   border: 1px solid #5F5F5F;
   vertical-align: middle;
}

#orderTable  td{
  border-collapse: collapse;
   border: 1px solid #5F5F5F;
   vertical-align: middle;
}

#orderTable : hover {
  background-color: black;
}

#checkout{
  font-style:italic;
color:#5F5F5F;
}

#checkout:hover{
  background-color: #5F5F5F;
  color: #FFFFFF;
  font-weight: bold;
}

div.dropdown-menu{

text-align: center;
}
a.dropdown_item{
  float: left;
margin: 0 auto;
  width: 100%;
  text-decoration: none;
  font-weight: bold;
  font-size: 1.5em;
}

a.dropdown_item:hover{
color: red;
background-color: yellow;
}

.dropdown-divider{
background-color: black;
padding: 5px;

}


.break{
clear: both;
}
</style>
  
 
 </head>
  <body style="background-image:  url('/CafeteriaApp.Frontend/images/customer background image4.jpg')" ng-app="myapp"   >
  
    <div id="wrapper"  >
        <!-- Navigation -->
      <nav class="navbar navbar-default " >

        <div class="container-fluid">
         
          <ul id="left_ul" class="nav navbar-nav">
            <li><a class="navbar-brand"  href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php"><?php echo "{$Words['Cafeterias'][$lang_id]} {$Words['Page'][$lang_id]}" ?></a></li>
          <li><a class="navbar-brand" href="#"><?php echo "{$Words['Home'][$lang_id]}" ?> </a></li>
          <li><a class="navbar-brand"  href="#"><?php echo "{$Words['Contact'][$lang_id]}" ?> </a></li>
          <li><a class="navbar-brand"  href="#"><?php echo "{$Words['Help'][$lang_id]}" ?></a></li>
          <li><a class="navbar-brand"  href="/CafeteriaApp.Frontend/Views/logout.php"><?php echo "{$Words['Log out'][$lang_id]}" ?></a></li>
          </ul>

          
            <div class="input-field col s12">
            <!-- <div class="select-wrapper"> -->
         <div  ng-controller="Language_Order"  ng-init=" languages=<?php echo htmlspecialchars($Languages);?>;selectedLang=languages[<?php echo ($lang_id-1) ; ?>];orderId=<?php echo $orderId;?>" >



         <ul id="right_ul" class="nav navbar-nav navbar-right ">

         <li style="margin-right:50px;" >
         <div class="row">
      <div class="col-xs-3">
      <div class="form-group">
      <select id="languages" class="selectpicker show-tick" select-picker ng-model="selectedLang" ng-options="l.Name for l in languages" ng-change="changeLanguage(selectedLang.Id)"  data-width="fit"> 
             <!-- <option value="" disabled >Choose the language</option> -->
            </select> 
         </div>
         </div>
         </div>
            <?php //$_SESSION["langId"]= "{{selectedLang.Id}}" ;  //echo __FILE__;        ?>
        </li>



        <li id="shoppingCart"  title="Show Shopping Cart Items"  style="width:50px;height:50px ">
       
            <div id="shoppingCart_Button" style="margin-top: 5px;">
              <img  src="/CafeteriaApp.Frontend/IconoCompraPaquetigos.png" style="width:100%;height:100% " >
            </div>

             <div id="shoppingCartDetails" >
              
                <h3 id="OrderItemsHeader">Order Items</h3>
                <div id="OrderContents" >
             
      <table id="orderTable" class="table table-bordered" ng-show="orderItems.length > 0"  >
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
            
            <td style="display:block;width:100%; padding: 0px;">

           <ul style="list-style: none; margin: 0px;padding: 0px;">
           <li><a  title="Increase Quantity" ng-click="increaseQuantity(o)" class="btn"><i class="fa fa-plus"></i></a></li>
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

      <!-- <div id="thead">Total: <span ng-bind="currentOrder.Total"></span></div> -->
      <div><a id="checkout" title="Check out this order" class="btn" type="button" ng-href="/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId={{orderId}}&categoryId={{categoryId}}"  ng-show="orderItems.length > 0"  target="_self"  >Checkout</a>
      </div>
    

         </div>
                  
            </div>

          </li>




        <li id="notification"  title="Show Notifications"  onclick="showNotifications()">
        <?php  
          $length = 0 ;
         if(!empty($_SESSION["notifications"]) && is_array($_SESSION["notifications"]))
          { 
              $ul="<ul style='color:blue;'>";
            foreach ($_SESSION["notifications"] as  $value) {
               $length++;
               $ul.= "<li>".$value[0]."</li>";
            }

            $ul.="</ul>";
            $_SESSION["notifications"] =  $ul;
            }
        if ( $length > 0) {
          echo " <img  src='/CafeteriaApp.Frontend/alarm-1.png' width='50' height='50' >";
           echo "<label id='notifyLabel' style='color:blue;font-size:2em;'>{$length}</label>";
         }
         else
         {
          echo " <img  src='/CafeteriaApp.Frontend/alarm.png' width='55' height='55' >";

         }
         ?>

        </li>


         <li id="myProfile">
         <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <?php echo "<h4>Hi, {$_SESSION['userName']}</h4>"; ?>
            </button>
          <div class="dropdown-menu">
            <a class="dropdown_item" href="/CafeteriaApp.Frontend/Areas/Customer/favorite items.php">My Favorites</a>
            <a class="dropdown_item" href="#">Another action</a>
            <a class="dropdown_item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown_item" href="#">Separated link</a>
         </div>
         </div>
         </li>

       
           </ul>
         
       </div>
          </div>
          </div>

      </nav>
    </div>



    <script src="/CafeteriaApp.Frontend/javascript/layout.js"></script>
