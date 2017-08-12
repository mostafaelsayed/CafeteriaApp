<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
 //require_once("CafeteriaApp.Backend/functions.php"); ?>

<!DOCTYPE html>
<html>


<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.eot" rel="font-woff">
  <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.svg" rel="font-woff">
  <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.ttf" rel="x-font-ttf">
  <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.woff" rel="font-woff">
  <link href="/CafeteriaApp.Frontend/fonts/glyphicons-halflings-regular.woff2" rel="font-woff">
  <link href="/CafeteriaApp.Frontend/css/font face.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/jquery-3.2.1.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/bootstrap.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-2.5.0.js"></script>

  <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-tpls-2.5.0.js"></script>
  <!-- <script src="/CafeteriaApp.Frontend/Scripts/libs/angular-route.js"></script> -->

  <script src="/CafeteriaApp.Frontend/javascript/angular-modal-service.js"></script>
  <!-- <script src="/CafeteriaApp.Frontend/Scripts/libs/knockout-3.4.2.js"></script> -->
  <!-- <script src="/CafeteriaApp.Frontend/Scripts/alertify/alertify.min.js"></script> -->
  <!-- Bootstrap Core CSS -->
  <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">



  <!-- MetisMenu CSS -->
  <link href="/CafeteriaApp.Frontend/css/metisMenu.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="/CafeteriaApp.Frontend/css/dataTables.bootstrap.css" rel="stylesheet">
  <!-- DataTables Responsive CSS -->
  <link href="/CafeteriaApp.Frontend/css/dataTables.responsive.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet">
  <!-- Morris Charts CSS -->
  <link href="/CafeteriaApp.Frontend/css/morris.css" rel="stylesheet">
  <!-- Custom Fonts -->
  <link href="/CafeteriaApp.Frontend/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff" rel="font-woff">
  <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff2" rel="octet-stream">
  <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.ttf" rel="x-font-ttf"> -->
  <script src="/CafeteriaApp.Frontend/javascript/metisMenu.min.js"></script>
  <!-- DataTables JavaScript -->
  <script src="/CafeteriaApp.Frontend/javascript/jquery.dataTables.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/dataTables.bootstrap.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/dataTables.responsive.js"></script>
  <!-- Morris Charts JavaScript -->
  <script src="/CafeteriaApp.Frontend/javascript/raphael.min.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/morris.min.js"></script>
  <!-- Custom Theme JavaScript -->
  <script src="/CafeteriaApp.Frontend/javascript/sb-admin-2.js"></script>


  <link href="/CafeteriaApp.Frontend/css/layout_style.css" rel="stylesheet" type="text/css">

    <script src="/CafeteriaApp.Frontend/javascript/myapp.js"></script>
    <!-- <script src="/CafeteriaApp.Frontend/javascript/layout.js"></script> -->


            <!-- <link rel="stylesheet" type="text/css" href="/CafeteriaApp.Frontend/Views/css/materialize.css"/> -->
        <!-- <script src="/CafeteriaApp.Frontend/Views/js/materialize.js"></script>   -->

  
 
 </head>
  <body style="background-image:	url('/CafeteriaApp.Frontend/images/customer background image4.jpg')" ng-app="myapp">

    <div id="wrapper"  >
        <!-- Navigation -->
      <nav class="navbar navbar-default navbar-fixed-top" style="background-image:  url('/CafeteriaApp.Frontend/images/customer background image4.jpg')">
        <div class="container-fluid">
          <ul class="nav navbar-nav">
            <li><a class="navbar-brand" style="color: blue" href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php">Cafeterias Page</a></li>
            <li><a class="navbar-brand" style="color: blue" href="#">Home</a></li>
            <li><a class="navbar-brand" style="color: blue" href="#"> <?php echo _("Contact");?></a></li>
            <li><a class="navbar-brand" style="color: blue" href="#"><?php echo _("Help");?></a></li>
            <li><a class="navbar-brand" style="color: blue" href="/CafeteriaApp.Frontend/Views/logout.php">Log out</a></li>

          </ul>

          
            <div class="input-field col s12">
            <!-- <div class="select-wrapper"> -->
         <div  ng-controller="Language"  >
         <ul class="nav navbar-nav navbar-right ">
         <li>
            <select   title="Display language" ng-model="selectedLang" ng-options="l.Name for l in languages" > 
            <option value="" disabled selected >Choose the language</option></select>
           <?php $_SESSION["langId"]="{{selectedLang.Id}}" ;  //echo __FILE__;        ?>
        </li>
         <li>
         <?php echo "<a title='Go to profile' href='/CafeteriaApp.Frontend/Areas/Customer/favorite items.php'><h4>Hi, {$_SESSION['userName']}</h4></a>"; ?>
         </li>
         
       </div>
         <!-- </div> -->
          </div>
           </ul>
          </div>

      </nav>
    </div>
        <!-- /#page-wrapper -->
<div> Copyright &copy;<?php echo date("Y"); ?>, Restaurant</div>

<script type="text/javascript">

app.controller('Language' , function ($scope,$http) {

$scope.getLanguages=function () {

$http.get('/CafeteriaApp.Backend/Requests/Languages.php')
.then(function(response) {

  $scope.languages=response.data;
},function(response) {

    console.log( "Something went wrong");
}
);
}


$scope.getLanguages();

  
});

</script>

 </body>
</html>