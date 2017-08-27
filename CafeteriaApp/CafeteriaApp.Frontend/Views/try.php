<?php require_once("CafeteriaApp.Backend/Controllers/Notification.php"); 
require_once("CafeteriaApp.Backend/connection.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">

  <script src="/CafeteriaApp.Frontend/javascript/bootstrap.min.js"></script>

        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">


	<title></title>

  <style>
    ul {
        display:block;
        background:#45619D;
        list-style:none;
        margin:0;
        padding:12px 10px;
        height:21px;
    }
    ul li {
        float:left;
        font:13px helvetica;
        font-weight:bold;
        margin:3px 0;
    }
    ul li a {
        color:#FFF;
        text-decoration:none;
        padding:6px 15px;
        cursor:pointer;
    }

    ul li a:hover {
        background:#425B90;
        text-decoration:none;
        cursor:pointer;
    }
    
    #noti_Container {
        position:relative;
    }

    /* THE POPULAR RED NOTIFICATIONS COUNTER. */
    #noti_Counter {
        display:block;
        position:absolute;
        background:#E1141E;
        color:#FFF;
        font-size:12px;
        font-weight:normal;
        padding:1px 3px;
        margin:-8px 0 0 25px;
        border-radius:2px;
        -moz-border-radius:2px; 
        -webkit-border-radius:2px;
        z-index:1;
    }

    /* A CIRCLE LIKE BUTTON IN THE TOP MENU. */
    #noti_Button {
        width:22px;
        height:22px;
        line-height:22px;
        border-radius:50%;
        -moz-border-radius:50%; 
        -webkit-border-radius:50%;
        background:#FFF;
        margin:-3px 10px 0 10px;
        cursor:pointer;
    }
   
    /* THE NOTIFICAIONS WINDOW. THIS REMAINS HIDDEN WHEN THE PAGE LOADS. */
    #notifications {
        display:none;
        width:430px;
        position:absolute;
        top:30px;
        left:0;
        background:#FFF;
        border:solid 1px rgba(100, 100, 100, .20);
        -webkit-box-shadow:0 3px 8px rgba(0, 0, 0, .20);
        z-index: 0;
    }
    /* AN ARROW LIKE STRUCTURE JUST OVER THE NOTIFICATIONS WINDOW */
/*    #notifications:before {         
        content: 'ssss';
        display:block;
        width:50;
        height:0;
        color:transparent;
        border:10px solid #CCC;
        border-color:transparent transparent #FFF;
        margin-top:-20px;
        margin-left:10px;
    }*/
        
    h3 {
        display:block;
        color:#333; 
        background:#FFF;
        font-weight:bold;
        font-size:13px;    
        padding:8px;
        margin:0;
        border-bottom:solid 1px rgba(100, 100, 100, .30);
    }
        
    .seeAll {
        background:#F6F7F8;
        padding:8px;
        font-size:12px;
        font-weight:bold;
        border-top:solid 1px rgba(100, 100, 100, .30);
        text-align:center;
    }
    .seeAll a {
        color:#3b5998;
    }
    .seeAll a:hover {
        background:#F6F7F8;
        color:#3b5998;
        text-decoration:underline;
    }
</style>
</head>
<body ng-app= "myapp" style="margin:0;padding:0;">
<div>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Find Friends</a></li>
            <li id="noti_Container">

                <div id="noti_Counter">
                </div>   <!--SHOW NOTIFICATIONS COUNT.-->
                
                <!--A CIRCLE LIKE BUTTON TO DISPLAY NOTIFICATION DROPDOWN.-->
                <div id="noti_Button">
                </div>    

                <!--THE NOTIFICAIONS DROPDOWN BOX.-->
                <div id="notifications">
                    <h3>Notifications</h3>
                    <div style="height:300px;">
                    </div>
                    <div class="seeAll"><a href="#">See All</a>
                    </div>
                </div>

            </li>
            <li><a href="#">Messages</a></li>
        </ul>
    </div>



<div ng-controller ="Ctrl" >
<div>

<select class="selectpicker show-tick"
    ng-model="selectedOption" 
    ng-options="option.Name for option in options"   ng-init=""  ng-change="getStuff(data.selectedOption)">
    <option>sss</option>
</select>
</div>
<div>
</div>
</div>

<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
  </div>
</div>


<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>

<script type="text/javascript">
	
var app = angular.module('myapp', []);

var langs=[];

app.controller('Ctrl',function($scope,$http) {

  $scope.getLanguages=function () {
//$scope.selectedOption ="";
$http.get('/CafeteriaApp.Backend/Requests/Languages.php')
.then(function(response) {
 $scope.options = response.data;
 $scope.func();
   $scope.ddd="dddddddddd";
  // console.log($scope.selectedOption);

  //langs= response.data;
  //console.log(langs);
 // console.log($scope.options );
// },function(response) {

//     console.log( "Something went wrong");
  });
}
		

$scope.func = function() {
  $scope.selectedOption = $scope.options[1];

}
 var dd="sss"+3;
 console.log(dd);
    $scope.getLanguages();
		//console.log($scope.options);
     // $scope.selectedOption = $scope.options[1];
});
	

</script>

<script>
    $(document).ready(function () {

        // ANIMATEDLY DISPLAY THE NOTIFICATION COUNTER.
        $('#noti_Counter')
            .css({ opacity: 0 })
            .text('7')              // ADD DYNAMIC VALUE (YOU CAN EXTRACT DATA FROM DATABASE OR XML).
            .css({ top: '-10px' })
            .animate({ top: '-2px', opacity: 1 }, 500);

        $('#noti_Button').click(function () {

            // TOGGLE (SHOW OR HIDE) NOTIFICATION WINDOW.
            $('#notifications').fadeToggle('fast', 'linear', function () {
                if ($('#notifications').is(':hidden')) {
                    $('#noti_Button').css('background-color', '#2E467C');
                }
                else $('#noti_Button').css('background-color', '#FFF');        // CHANGE BACKGROUND COLOR OF THE BUTTON.
            });

            $('#noti_Counter').fadeOut('slow');                 // HIDE THE COUNTER.

            return false;
        });

        // HIDE NOTIFICATIONS WHEN CLICKED ANYWHERE ON THE PAGE.
        $(document).click(function () {
            $('#notifications').hide();

            // CHECK IF NOTIFICATION COUNTER IS HIDDEN.
            if ($('#noti_Counter').is(':hidden')) {
                // CHANGE BACKGROUND COLOR OF THE BUTTON.
                $('#noti_Button').css('background-color', '#2E467C');
            }
        });

        $('#notifications').click(function () {
            return false;       // DO NOTHING WHEN CONTAINER IS CLICKED.
        });
    });
</script>