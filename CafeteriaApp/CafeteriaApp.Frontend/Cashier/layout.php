<?php require(__DIR__.'/../CafeteriaApp.Backend/functions.php');

checkGetParams();
?>
<!DOCTYPE html>

<html>

  <head>

      <meta charset="utf-8" />

      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Bootstrap Core CSS -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">

      <link href="../css/form_validation.css" rel="stylesheet">

      <!-- DataTables CSS -->
      <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
      <!-- DataTables Responsive CSS -->
      <link href="../css/dataTables.responsive.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="../css/sb-admin-2.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

      <link href="../css/admin style.css" rel="stylesheet">

  </head>

  <body style="background-image: url('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/admin background image.jpg')">

    <div>
      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-fixed-top" style="background-image: url('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/admin background image.jpg')">

        <div class="container-fluid">

          <ul class="nav navbar-nav">

            <li><a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Cashier/Order/Views/show_and_hide_orders.php">Manage Orders</a></li>

            <li><a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/logout.php">Log out</a></li>

          </ul>

          <form action="/TestI18N/language.php" method="post" style="float: right">

            <input type="submit" name="english" value="English" />

            <input type="submit" name="german" value="German" />

          </form>

        </div>

      </nav>

    </div>
    <!-- /#page-wrapper -->

    <div> Copyright &copy;<?php echo date("Y"); ?>, Restaurant</div>

  </body>

</html>

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/angular.min.js"></script>
<script src="../js/angular-route.js"></script>
<script src="../js/ui-bootstrap-2.5.0.js"></script>
<script src="../js/ui-bootstrap-tpls-2.5.0.js"></script>
<script src="../js/angular-modal-service.js"></script>
<script src="../js/location_provider.js"></script>
<script src="../js/customer_and_cashier_order.js"></script>
<script src="../js/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../js/sb-admin-2.js"></script>