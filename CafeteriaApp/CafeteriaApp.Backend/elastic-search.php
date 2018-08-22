<?php

use Elasticsearch\ClientBuilder;

require __DIR__ . '/lib/vendor/autoload.php';

function search($conn, $index, $type, $field, $fieldValue) {
	$hosts = [
		'localhost:9200'
	];

	$client = ClientBuilder::create()->setHosts($hosts)->build();

	$params = [
	    'index' => $index,
	    'type' => $type,
	    'body' => [
	        'query' => [
	        	// for multiple terms
	        	'match' => [$field => ['query' => $fieldValue, 'fuzziness' => 2] ],
	        	// for single terms
	            // 'fuzzy' => ["Name" => ["value" => "green sala", "fuzziness" => 2, "transpositions" => false]],
	        ]
	    ]
	];

	$arr = [];

	$response = $client->search($params)['hits']['hits'];

	foreach ($response as $key => $value) {
		$sql = "select * from `menuitem` where `Name` = '{$value['_source']['Name']}'";
		$res = $conn->query($sql);

		if (!$res) {
			echo $conn->error;
		}
		
		$menuItem = mysqli_fetch_assoc($res);
		array_push($arr, $menuItem);
	}

	$_SESSION['filteredData'] = $arr;

	return $arr;
}

function index($index, $type, $field, $fieldValue) {
	$hosts = [
		'localhost:9200'
	];

	$client = ClientBuilder::create()->setHosts($hosts)->build();

	$params = [
		'index' => $index,
	    'type' => $type,
	    'id' => '7',
	    'body' => [$field => $fieldValue]
	];

	$response = $client->index($params);

	return $response;
}

// function deleteDoc()



// $indParams = [
// 	'index' => 'cafeteria'
// ];

//$client = new Elasticsearch\Client($hosts);
//$connectionPool = '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool';



//try {
//  $r = $client->indices()->delete(['index' => 'cafeteria']);

// print_r($r);
	// $r = $client->indices()->create($indParams);

	// print_r($r);

	//$client->types()
//}

// catch (Exception $e) {
// 	;
// }




// $params = [
// 	'index' => 'cafeteria',
//     'type' => 'menuitem',
//     'id' => '7',
//     'body' => ['Name' => 'bread']
// ];

//$response = $client->index($params);



// //$response = $client->delete($params);

//print_r($response);

// $r = $client->indices()->exists(['index' => 'cafeteria']);
// var_dump($r);