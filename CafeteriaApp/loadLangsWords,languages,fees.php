<meta charset="utf-8" />

<?php 
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Languages.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Fee.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Words.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');

$languages = getLanguages($conn); // MYSQLI_ASSOC
$fees = getFees($conn); // MYSQLI_ASSOC
$words = getWords($conn , MYSQLI_NUM); // MYSQLI_ASSOC
$memcache = memcache_connect('localhost', 11211);
//print_r($words);
 if ($memcache) {

		$fees2 = array();
		$words2 = array();



	foreach ($fees as $key => $value) {
			
		$fees2[$value["Name"]] = $value["Price"];

		}


		foreach ($words as $key => $value) {
			
		$words2[$value[1]] = $value;// 0 is the index of id

		}

 		
	

	//$words = new StdClass;
	//$words->attribute = 'test';
	$memcache->set("words", $words2);
	$memcache->set("fees", $fees2);
	$languages = json_encode($languages);
	$memcache->set("languages", $languages);

	//$array = Array('assoc'=>123, 345, 567);
	//$memcache->set("arr_key", $array);

	//var_dump($memcache->get('str_key'));
	//var_dump($memcache->get('num_key'));
	var_dump($memcache->get('languages'));

	unset($languages);
 		unset($fees);
		unset($words);
}
else {
	echo "Connection to memcached failed";
}


require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');
 ?>