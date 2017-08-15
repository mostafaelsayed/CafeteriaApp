<meta charset="utf-8" />

<?php 
require_once( 'CafeteriaApp.Backend/Controllers/Words.php');
require_once("CafeteriaApp.Backend/connection.php");

//$object = getWords($conn , MYSQLI_NUM); // MYSQLI_ASSOC
$memcache = memcache_connect('localhost', 11211);
//print_r($object);
 if ($memcache) {

// 		$object2 = array();

// 		foreach ($object as $key => $value) {
			
// 		$object2[$value[1]]= $value;

// 		}
		 //unset($object);
	//$memcache->set("str_key", "String to store in memcached");
	//$memcache->set("num_key", 123);

	//$object = new StdClass;
	//$object->attribute = 'test';
	//$memcache->set("obj_key", $object2);

	//$array = Array('assoc'=>123, 345, 567);
	//$memcache->set("arr_key", $array);

	//var_dump($memcache->get('str_key'));
	//var_dump($memcache->get('num_key'));
	var_dump($memcache->get('obj_key'));
}
else {
	echo "Connection to memcached failed";
}


require_once("CafeteriaApp.Backend/footer.php");
 ?>