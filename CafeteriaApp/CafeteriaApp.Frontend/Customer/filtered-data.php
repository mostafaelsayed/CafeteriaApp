<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2]);
?>

<head>

  <title>Cafeterias</title>

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/customer styles.css" rel="stylesheet">

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/popup.css" rel="stylesheet">

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/stars.css" rel="stylesheet">

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.bootstrap.css" rel="stylesheet">

  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.core.css" rel="stylesheet">
  
  <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/alertify.default.css" rel="stylesheet">

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/alertify.js"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/show_cafeterias.js"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/filtered-data.js"></script>

  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/about_slide_toggle.js"></script>

</head>

		<?php require(__DIR__ . '/customer-order-and-menuitems.php'); ?>

	</div>

</div>