<?php
    require(__DIR__ . '/../../CafeteriaApp.Backend/functions.php');
    validatePageAccess([1]);
?>
<!DOCTYPE html>

<html>

    <head>

        <meta http-equiv="X-UA-Compatible" name="viewport" content="IE=11,width=device-width,initial-scale=1.0" charset="utf-8" />

        <link href="/favicon" rel="icon">

        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <!-- form validations style -->
        <link href="/css/form_validation.css" rel="stylesheet">


        <!-- sb-admin CSS -->
        <link href="/css/sb-admin-2.css" rel="stylesheet">

        <!-- font awesome -->
        <link href="/css/font-awesome.min.css" rel="stylesheet">

        <!-- admin style -->
        <link href="/css/admin style.css" rel="stylesheet">

        
    </head>

    <body style="background-image:url('/images/admin background image.jpg');background-repeat: no-repeat;background-size: 1430px 1300px">

        <div>

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" style="background-image: url('/images/admin background image.jpg')">

                <div class="container-fluid">

                    <div class="navbar-header">

                        <a style="color: white" class="navbar-brand" href="/admin/category/show">Manage Categories</a>

                    </div>

                    <ul class="nav navbar-nav">

                        <li>

                            <a style="color: white" class="navbar-brand" href="/admin/user/show">Manage Users</a>

                        </li>

                        <li>

                            <a style="color: white" class="navbar-brand" href="/admin/fees/show">Manage Fees</a>

                        </li>

                        <li>

                            <a style="color: white" class="navbar-brand" href="/logout.php">Log out</a>

                        </li>

                    </ul>

                </div>

            </nav>

        </div>

        <!-- /#page-wrapper -->
        <div> Copyright &copy;<?php echo date("Y"); ?>, Restaurant</div>

    </body>

</html>

<script src="/js/jquery-3.2.1.min.js"></script>
<!-- angular module -->
<script src="/js/angular.min.js"></script>
<script src="/js/metisMenu.min.js"></script>
<!-- sb-admin JavaScript -->
<script src="/js/sb-admin-2.js"></script>


<script type="text/javascript">
    $.urlParam = function(pos) {
      // var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

      // if (results == null) {
      //   return null;
      // }
      // else {
      //   return decodeURI(results[1]) || 0;
      // }

     
      var arr = window.location.href.split('/').reverse();
      var res = arr[pos];

      return res;
    }
</script>