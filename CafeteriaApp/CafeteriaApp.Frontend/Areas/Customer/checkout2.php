<title> Order info</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Customer/layout.php');
    if( !isset($_GET["orderId"]) || !isset($_GET["deliveryTimeDuration"]) )
    	{
	$_GET["orderId"]=0;
		$_GET["deliveryTimeDuration"]=0;
    	}

?>

<script src="/CafeteriaApp.Frontend/Scripts/customer/checkout2.js"></script>

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
            Delivered within &nbsp; &gt; <span><?php echo "{$_GET["deliveryTimeDuration"]}"; ?></span> &nbsp; Minutes</td>
          </tr>
        <tr>
            
          </tr>
        
        </tbody>
      </table>
      </div>

      <!-- </body> -->