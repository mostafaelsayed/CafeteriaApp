<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap Core CSS -->
        <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">

        <!-- form validations style -->
        <link href="/CafeteriaApp.Frontend/css/form_validation.css" rel="stylesheet">

        <!-- sb-admin CSS -->
        <link href="/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet">

        <!-- font awesome -->
        <link href="/CafeteriaApp.Frontend/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- admin style -->
        <link href="/CafeteriaApp.Frontend/css/admin style.css" rel="stylesheet">

        <script src="/CafeteriaApp.Frontend/javascript/jquery-3.2.1.min.js"></script>

        <!-- angular module -->
        <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>

        <script src="/CafeteriaApp.Frontend/javascript/metisMenu.min.js"></script>

        <!-- sb-admin JavaScript -->
        <script src="/CafeteriaApp.Frontend/javascript/sb-admin-2.js"></script>
        
    </head>

    <body style="background-image:url('/CafeteriaApp.Frontend/images/admin background image.jpg')">

        <div>

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" style="background-image:url('/CafeteriaApp.Frontend/images/admin background image.jpg')">

                <div class="container-fluid">

                    <div class="navbar-header">

                        <a style="color:white" class="navbar-brand" href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show_and_delete_cafeterias.php">Manage Cafeterias</a>

                    </div>

                    <ul class="nav navbar-nav">

                        <li>

                            <a style="color:white" class="navbar-brand" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/show_and_delete_users.php">Manage Users</a>

                        </li>

                        <li>

                            <a style="color:white" class="navbar-brand" href="/CafeteriaApp.Frontend/Areas/Admin/AppSettings/Views/show_and_delete_fees.php">Manage Fees</a>

                        </li>

                        <li>

                            <a style="color:white" class="navbar-brand" href="/CafeteriaApp.Frontend/Views/logout.php">Log out</a>

                        </li>

                    </ul>

                </div>

            </nav>

        </div>

        <!-- /#page-wrapper -->
        <div> Copyright &copy;<?php echo date("Y"); ?>, Restaurant</div>

    </body>

</html>