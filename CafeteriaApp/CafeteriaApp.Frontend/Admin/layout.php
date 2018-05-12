<?php
    require(__DIR__ . '/../../CafeteriaApp.Backend/functions.php');
    validatePageAccess([1]);
?>
<!DOCTYPE html>

<html>

    <head>

        <meta name="viewport" content="width=device-width,initial-scale=1.0" charset="utf-8" />

        <link href="/CafeteriaApp/CafeteriaApp/favicon.ico" rel="icon">

        <!-- Bootstrap Core CSS -->
        <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">

        <!-- form validations style -->
        <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/form_validation.css" rel="stylesheet">


        <!-- sb-admin CSS -->
        <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet">

        <!-- font awesome -->
        <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/font-awesome.min.css" rel="stylesheet">

        <!-- admin style -->
        <link href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/admin style.css" rel="stylesheet">

        
    </head>

    <body style="background-image:url('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/admin background image.jpg');background-repeat: no-repeat;background-size: 1430px 1300px">

        <div>

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" style="background-image: url('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/admin background image.jpg')">

                <div class="container-fluid">

                    <div class="navbar-header">

                        <a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Admin/Category/show_and_delete_categories.php">Manage Categories</a>

                    </div>

                    <ul class="nav navbar-nav">

                        <li>

                            <a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Admin/User/show_and_delete_users.php">Manage Users</a>

                        </li>

                        <li>

                            <a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Admin/AppSettings/show_and_delete_fees.php">Manage Fees</a>

                        </li>

                        <li>

                            <a style="color: white" class="navbar-brand" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/logout.php">Log out</a>

                        </li>

                    </ul>

                </div>

            </nav>

        </div>

        <!-- /#page-wrapper -->
        <div> Copyright &copy;<?php echo date("Y"); ?>, Restaurant</div>

    </body>

</html>

<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/jquery-3.2.1.min.js"></script>
<!-- angular module -->
<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/angular.min.js"></script>
<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/metisMenu.min.js"></script>
<!-- sb-admin JavaScript -->
<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/sb-admin-2.js"></script>


<script type="text/javascript">
    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

      if (results == null) {
        return null;
      }
      else {
        return decodeURI(results[1]) || 0;
      }
    }
</script>