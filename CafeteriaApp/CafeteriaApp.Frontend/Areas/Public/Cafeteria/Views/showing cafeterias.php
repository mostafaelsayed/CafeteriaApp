<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  require_once('CafeteriaApp.Frontend/Areas/Customer/layout.php');
?>

<div style="display:none;margin-bottom:50px;margin-top:50px;" id="notifyme">

<h1 style="color: blue;">Notifications :</h1> 

<?php echo !empty( $_SESSION["notifications"])? $_SESSION["notifications"] : "<h2 style='color: blue;'>Nothing has been changed !</h2>" ;?>

</div>

<title>Cafeterias</title>


 <script src="/CafeteriaApp.Frontend/javascript/showing cafeterias.js"></script>

<h1 class="page-header" id="header">Our Cafeterias</h1>

<div  ng-controller="Cafeterias">
<div >
  <div  id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to=0 class="active"></li>
        <li ng-repeat="c in cafeterias.slice(1,cafeterias.length)" data-target="#myCarousel" data-slide-to={{cafeterias.indexOf(c)}}></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active">
        <a ng-href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing categories of a cafeteria.php?id={{cafeterias[0].Id}}">
          <img style="display:block;margin:auto" ng-src={{cafeterias[0].Image}} width="500" height="400" />
        </a>
        <h3 ng-bind="cafeterias[0].Name" class="carousel-caption"></h3>
      </div>
      <div ng-repeat="c in cafeterias.slice(1,cafeterias.length)" class="item">
        <a ng-href="/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing categories of a cafeteria.php?id={{c.Id}}">
          <img style="display:block;margin:auto" ng-src={{c.Image}} width="500" height="400" />
        </a>
        <h3 ng-bind="c.Name" class="carousel-caption"></h3>
      </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  </div>
</div>
 




<script type="text/javascript"> 

function showNotifications(){
  $('#notifyLabel').html('');
  //$('#notifyme').css({"display":"block"});
  $("#notifyme").slideToggle("slow");

  //role="dialog"
}
</script>