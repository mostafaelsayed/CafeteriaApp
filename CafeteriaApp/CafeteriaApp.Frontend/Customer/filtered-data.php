<?php
  require(__DIR__.'/../../CafeteriaApp.Backend/functions.php');
  validatePageAccess($conn);
  require(__DIR__.'/../layout.php');
?>

<head>

  <title>Cafeterias</title>

  <link href="../../css/customer styles.css" rel="stylesheet">

  <link href="../../css/popup.css" rel="stylesheet">

  <link href="../../css/stars.css" rel="stylesheet">

  <link href="../../css/alertify.bootstrap.css" rel="stylesheet">

  <link href="../../css/alertify.core.css" rel="stylesheet">
  
  <link href="../../css/alertify.default.css" rel="stylesheet">

  <script src="../../javascript/alertify.js"></script>

  <script src="../../javascript/show_cafeterias.js"></script>

  <script src="../../javascript/filtered-data.js"></script>

  <script src="../../javascript/about_slide_toggle.js"></script>

</head>

		<?php require('customer-order-and-menuitems.php'); ?>

	</div>

</div>