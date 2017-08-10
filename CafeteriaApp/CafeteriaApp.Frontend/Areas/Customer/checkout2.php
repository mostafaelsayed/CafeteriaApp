<title> Order info</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
    if( !isset($_GET["orderId"]) || !isset($_GET["deliveryTimeDuration"]) )
    	{
	$_GET["orderId"]=0;
		$_GET["deliveryTimeDuration"]=0;
    	}

?>

<script src="/CafeteriaApp.Frontend/javascript/checkout2.js"></script>

<br>
<div ng-app="myapp" ng-controller="OrderCheckout2" ng-init=<?php echo "orderno={$_GET["orderId"]}" ?>  style="align-content:center;text-align:center;">


<table align="center" >
        <thead>
          <tr>
            <th ><h1>Order #<span ng-bind="orderno" ></span></h1> </th>
          </tr>
        </thead>
        <tbody >
          <tr>
          <td>
            Name :<span ng-bind="name"></span>
            </td>
          </tr>
        <tr><td>
            Status : Shipped</td>
          </tr>
        <tr><td>
            Preparation Time within &nbsp; &gt; <span><?php echo "{$_GET["deliveryTimeDuration"]}"; ?></span> &nbsp; Minutes</td>
          </tr>
        <tr><td>
            Delivered Time within: depends on your location </td>
          </tr>
        <tr><td>
            Other Fees : i.e. for delivery </td>
          </tr>
        </tbody>
      </table>
      </div>

      <!-- </body> -->