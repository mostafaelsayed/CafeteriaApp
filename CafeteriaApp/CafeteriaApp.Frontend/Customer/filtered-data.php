<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2]);
?>

<head>

  <title>Cafeterias</title>

  <link href="/css/customer styles.css" rel="stylesheet">

  <link href="/css/popup.css" rel="stylesheet">

  <link href="/css/stars.css" rel="stylesheet">

  <link href="/css/alertify.bootstrap.css" rel="stylesheet">

  <link href="/css/alertify.core.css" rel="stylesheet">
  
  <link href="/css/alertify.default.css" rel="stylesheet">

  <script src="/js/alertify.js"></script>

  <script src="/js/show_categories.js"></script>

  <script src="/js/filtered-data.js"></script>

  <script src="/js/about_slide_toggle.js"></script>

</head>

		<?php require(__DIR__ . '/customer-order-and-menuitems.php'); ?>

	</div>

</div>