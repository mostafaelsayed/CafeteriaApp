<?php

  require(__DIR__.'/../layout.php');
  //validatePageAccess([1,2]);

?>

<head>

  <title>Menu Items</title>

  <link href="../css/alertify.bootstrap.css" rel="stylesheet">
  <link href="../css/alertify.core.css" rel="stylesheet">
  <link href="../css/alertify.default.css" rel="stylesheet">
  <link  href="../css/customer.css" rel="stylesheet">
  <link href="../css/popup.css" rel="stylesheet">
  <link href="../css/stars.css" rel="stylesheet">
</head>

    <?php require(__DIR__.'/customer-order-and-menuitems.php'); ?>
  <div style="text-align: center;">
      <a onclick="$('.about').slideToggle('slow');" style="cursor:pointer;">About this menu</a>
  </div>
    <!-- </div> -->

    <div  class="about" style="margin: 0 auto;text-align: center;color: white;padding:20px;">
      <p>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</p>

    </div>

  </div>

</div>

<?php require(__DIR__.'/footer.php'); ?>

<script src="../js/alertify.js"></script>
<script src="../js/about_slide_toggle.js"></script>
<script src="../js/show_menuitems_of_a_category_and_customer_order.js"></script>