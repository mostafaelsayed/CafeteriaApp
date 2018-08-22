<?php
  require_once(__DIR__ . '/../layout.php');
  $loggedIn = isset($_SESSION['userId']) ? true : false;
?>

<head>
  <title>Menu Items</title>
  <link href="/css/alertify.bootstrap.css" rel="stylesheet">
  <link href="/css/alertify.core.css" rel="stylesheet">
  <link href="/css/alertify.default.css" rel="stylesheet">
  <link href="/css/customer.css" rel="stylesheet">
  <link href="/css/popup.css" rel="stylesheet">
  <link href="/css/stars.css" rel="stylesheet">
</head>

<style type="text/css">
  .img-block {
    display: inline-block;
    border: 1px solid;
  }
</style>

<div class="container">

  <div style="text-align: center">

    <?php if (isset($_GET['categoryName'])) { ?>
      <h1 style="color: #965C2A;padding-bottom: 20px;margin-bottom: 20px;border-bottom: 3px solid #31B0D5;font-family: fontAwsome;font-size: 4rem;text-shadow: 2px 2px rgba(0, 5, 0, .15);">
        <?=$_GET['categoryName']?>
      </h1>
    <?php } ?>

    <div class="popup" style="position: fixed;">
      <span class="popuptext" id="myPopup">A Simple Popup!</span>
    </div>
    
  </div>

  <?php require __DIR__ . '/../Customer/customer-order-and-menuitems.php'; ?>

  <div style="text-align: center;">
    <a onclick="$('.about').slideToggle('slow');$(this).children('span').toggleClass('glyphicon-minus glyphicon-plus');" style="cursor: pointer;"> <span class="glyphicon glyphicon-minus"></span> About this menu</a>
  </div>

  <div class="about" style="margin: 0 auto;text-align: center;color: white;padding: 20px;">
    <p>we have special menuitems here with affordable price.Take a look at our dishes and have fun!</p>
  </div>

</div>

<?php require(__DIR__ . '/footer.php'); ?>

<script src="/js/alertify.js"></script>
<script src="/js/about_slide_toggle.js"></script>
<script src="/js/show_menuitems_and_order.js"></script>