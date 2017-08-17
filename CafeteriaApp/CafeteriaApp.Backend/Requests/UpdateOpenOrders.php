<?php 
require_once( 'CafeteriaApp.Backend/Controllers/Order.php');
require_once( 'CafeteriaApp.Backend/Controllers/OrderItem.php');
require_once('CafeteriaApp.Backend/Controllers/MenuItem.php');
require_once("CafeteriaApp.Backend/connection.php");

$ids= array();
$flattenOrderItems= array();

function explodeArray2($n)
{	
	global $ids;
	array_push($ids, $n["MenuItemId"]);

	global $flattenOrderItems;
	array_push($flattenOrderItems, $n);
	//return $n;
}


function explodeArray1($arr1)
{	
	 array_map("explodeArray2", $arr1);
}

//1-get all open orders where open status id =1
$orders = getOrdersByOrderStatusId($conn , 1);

//2-get all order items 
$orderItems = array();
foreach ($orders as $key => $order) {
array_push($orderItems, getOrderItemsByOpenOrderId($conn ,$order["Id"])) ;
}

//get Menu Items distinct Ids in array and flatten order items 
array_map("explodeArray1", $orderItems);

//3-Menu Items distinct Ids in array 
$ids = array_unique($ids,SORT_NUMERIC);

//3-Menu Items in array 
$menuItems =getMenuItemsByIds($conn,$ids);

//4- update all total price and visiblity
//process each order alone

//visibilty first
//delete invisible from orderitems  
//total price for order items
foreach ($menuItems as $key => $menuItem) {
	if(!$menuItem["Visible"])
	{
	deleteOrderItemsByMenuItemId($conn, $menuItem["Id"]);	//remove from db
	}
	
	foreach ($flattenOrderItems as $key => $OrderItem) {
	if($menuItem["Id"]===$OrderItem["MenuItemId"] ){
		if(!$menuItem["Visible"])
		{
			unset($flattenOrderItems[$key]);//remove from front
		}
		else{
	 			//update price
			//$flattenOrderItems[$key]["TotalPrice"]=$menuItem["Price"]*$OrderItem["Quantity"];
			//update order items total price in db
			editOrderItemTotalPrice($conn,$menuItem["Price"]*$OrderItem["Quantity"],$OrderItem["Id"]  );
		}
	}
	}
	
}

//total price for each order in db 

foreach ($orders as $key => $order) {
	calcAndUpdateOrderTotalById($conn ,$order["Id"]);
}




//5-leave a message for the customer who ordered







//merge arrays
//$ids =array_merge_recursive($orderItems);
?>