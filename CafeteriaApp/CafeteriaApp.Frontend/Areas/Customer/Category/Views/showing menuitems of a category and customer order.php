<?php

  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php');

  validatePageAccess($conn);

  require('../../layout.php');

?>

<head>

  <title>MenuItems</title>

  <link href="../../../../css/alertify.bootstrap.css" rel="stylesheet">

  <link href="../../../../css/alertify.core.css" rel="stylesheet">
  
  <link href="../../../../css/alertify.default.css" rel="stylesheet">

  <link  href="../../../../css/customer styles.css" rel="stylesheet">

  <link href="../../../../css/popup.css" rel="stylesheet">

  <link href="../../../../css/stars.css" rel="stylesheet">

  <script src="../../../../javascript/alertify.js"></script>

  <script src="../../../../javascript/about_slide_toggle.js"></script>

  <script src="../../../../javascript/show_menuitems_of_a_category_and_customer_order.js"></script>

</head>

    <?php require('../../customer-order-and-menuitems.php'); ?>

    <a onclick="slideAbout()">About This category</a>

    <!-- </div> -->

    <div class="about" style="margin: 0 auto;text-align: center;color: white">

      <h1>About This Category</h1>

      <p>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</p>

    </div>

  </div>

</div>

<?php require('../../../footer.php'); ?>