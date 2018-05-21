<!DOCTYPE html>

<html>

  <head>

    <title>Register</title>

    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0" />

    <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Anton"> -->

    <link rel="icon" href="../favicon.ico">

    <link rel="stylesheet" type="text/css" href="css/materialize.css" />

    <link href="css/input_file.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="icons/icons.css" />

    <link href="css/errors.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="css/register.css" />

    <!-- replace with the minimized version in production -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- replace with the minimized version in production -->
    <script src="js/angular.min.js"></script>

    <script src="js/newjavascript.js"></script>

    <script src="js/materialize.js"></script>

    <script src="js/image_module.js"></script>

    <script type="text/javascript" src="js/register_form_validation.js"></script>

    <script type="text/javascript">

      angular.module('registerApp', ['image', 'registerFormValidation']).controller('registerController', ['$scope', function($scope) {
          $scope.image = {};
          $scope.image.src = '';
      }]);
      
    </script>

    <style type="text/css">

      .errorMes {
        color: red;
      }

      label {
        font-family: 'Anton';
      }
      
    </style>

  </head>

  <body style="background-image: url('');background-repeat: no-repeat;background-size: cover">

    <div>

      &nbsp;

    </div>
    
    <h2 style="text-align: center;color: violet">New User</h2>

    <div ng-app="registerApp" ng-controller="registerController" class="row">

      <form ng-cloak novalidate role="form" name="myform" style="width: 40%;margin: auto;text-align: center" enctype="multipart/form-data" method="post" action="../CafeteriaApp.Backend/Requests/User.php">

        <div class="input-field col s12">

          <label>First Name</label>

          <input type="text" ng-model="firstName" name="firstName" style="text-align: center" required />

          <div class="errorMes" ng-show="myform.firstName.$touched && myform.firstName.$invalid">

            First Name is Required

          </div>

        </div>

        <div class="input-field col s12">

          <label>Last Name</label>

          <input type="text" ng-model="lastName" name="lastName" style="text-align: center" required />

          <div class="errorMes" ng-show="myform.lastName.$touched && myform.lastName.$invalid">

            Last Name is Required

          </div>

        </div>

        <div class="input-field col s12">

          <label>E-mail</label>

          <input check ng-model="email" type="email" name="email" style="text-align: center" required />

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailEmpty">

            Email is Required

          </div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && !myform.email.$error.emailEmpty && !myform.email.$error.emailExisted && myform.email.$invalid">

            Email is invalid

          </div>

          <div class="errorMes" ng-show="(myform.email.$touched || myform.$submitted) && myform.email.$error.emailExisted">

            Email already existed

          </div>

        </div>

        <div class="input-field col s12">

          <label>Password</label>

          <input check type="password" name="password" ng-model="password" style="text-align: center" required />

          <div class="errorMes" ng-show="(myform.password.$touched || myform.$submitted) && myform.password.$error.passEmpty">

            Password is Required

          </div>

          <div class="errorMes" ng-show="(myform.password.$touched || myform.$submitted) && myform.password.$error.checkPassword && !myform.password.$error.passEmpty">

            Password is Invalid. It must contain at least one lowercase letter, one uppercase letter and one digit

          </div>

        </div>

        <div class="input-field col s12">
          
          <label>Confirm Password</label>

          <input class="inputField" check type="password" class="form-control" ng-model="confirmPassword" name="confirmPassword" required />

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && myform.confirmPassword.$error.confirmPassEmpty">

            Confirm Password is Required

          </div>

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && !myform.confirmPassword.$error.checkConfirmPassword && !myform.confirmPassword.$error.confirmPassEmpty && password != confirmPassword">

            Confirm Password is not as the password

          </div>

          <div class="errorMes" ng-show="(myform.confirmPassword.$touched || myform.$submitted) && myform.confirmPassword.$error.checkConfirmPassword && !myform.confirmPassword.$error.confirmPassEmpty">
            
            Confirm Password is Invalid. It must contain at least one lowercase letter, one uppercase letter and one digit

          </div>

        </div>

        <div class="input-field col s12">

          <label>Phone Number</label>

          <input type="text" check ng-model="phone" name="phone" style="text-align: center" required />

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.checkPhoneNumber && !myform.phone.$error.phoneEmpty">

            Phone Number is Invalid. It must has 11 digits starting with 01

          </div>

          <div class="errorMes" ng-show="(myform.phone.$touched || myform.$submitted) && myform.phone.$error.phoneEmpty">

            Phone Number is Required

          </div>

        </div>

        <div class="input-field col s12">

          <input check name="DOB" ng-model="DOB" type="date" class="datepicker" required />

          <label>Date of Birth</label>

          <div class="errorMes" ng-show="(myform.DOB.$touched || myform.$submitted) && myform.DOB.$error.birthEmpty">

            Date of Birth is Required

          </div>

          <div class="errorMes" ng-show="(myform.DOB.$touched || myform.$submitted) && !myform.DOB.$error.birthEmpty && myform.DOB.$error.checkBirth">

            Date of Birth is Invalid

          </div>

          <br><br>

        </div>

        <label class="labels" style="font-size: 16px">Gender</label>

        <br><br>

        <input class="with-gap" name="genderId" type="radio" value="1" id="male" required />

        <label for="male">Male</label>

        <br>

        <input class="with-gap" name="genderId" type="radio" value="2" id="female" required />

        <label for="female" style="margin-right: -17px">Female</label>

        <div class="errorMes" ng-show="myform.genderId.$touched && myform.genderId.$invalid">

          Gender is Required

        </div>

        <br><br><br>

        <button class="btn btn-info" onclick="event.preventDefault();$('#file').trigger('click')">Choose Image</button> 

        <br><br>

        <!-- let user decide whether to crop or not -->
        <!-- <button onclick="event.preventDefault();crop();">Crop Image</button> -->

        <input type="file" id="file" name="image" class="inputfile" onchange="readURL(this)">

        <div id="container">

          <div id="parent"></div>

          <br><br><br>

          <div id="cont">

            <img id="inner" />

          </div>

        </div>

        <br>

        <input type="hidden" name="x1" value="" />
        <input type="hidden" name="y1" value="" />
        <!-- <input type="hidden" name="x2" value="" />
        <input type="hidden" name="y2" value="" /> -->
        <input type="hidden" name="w" value="" />
        <input type="hidden" name="h" value="" />

        <div>
          <input ng-if="myform.$invalid" type="button" name="submit" class="btn btn-primary" style="text-align: center" value="Register" />
          
          <input ng-if="myform.$valid" type="submit" name="submit" style="text-align: center" class="btn btn-primary" value="Register" />
        </div>
        
      </form>

    </div>

    <br>

  </body>

</html>


<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.css">
<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.js"></script>

<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/crop.js"></script>





<!-- jquery cropper -->

<!-- <script src="js/node_modules/cropperjs/dist/cropper.js"></script>
<link href="js/node_modules/cropperjs/dist/cropper.css" rel="stylesheet">
<script src="js/node_modules/jquery-cropper/dist/jquery-cropper.js"></script>
<script>

document.getElementById('image').onload = function() {
  var $image = $('#image');

  if (cropper != undefined) {
    cropper.destroy();
  }

  $image.cropper({
    preview: '#cont', // container of preview
    aspectRatio: 1 / 1,
    crop: function(event) {
      
      var cropper = $image.data('cropper');
     
      newX = event.detail.x;
      newY = event.detail.y;
      newWidth = event.detail.width;
      newHeight = event.detail.height + 4;
      
      var scaleX = 150 / (newWidth || 1);
      var scaleY = 150 / (newHeight || 1);

      $('#inner').css({
        width: Math.round( scaleX * $('#image').width() ) + 'px',
        height: Math.round( scaleY * $('#image').height() ) + 'px',
        marginLeft: '-' + Math.round(scaleX * newX) + 'px',
        marginTop: '-' + Math.round(scaleY * newY) + 'px'
      });

      $('input[name="x1"]').val(newX);
      $('input[name="y1"]').val(newY);
      $('input[name=w]').val(newWidth);
      $('input[name=h]').val(newHeight);
    }
  });

  cropper = $image.data('cropper');
  // Get the Cropper.js instance after initialized
}

</script> -->


<!-- jcrop -->

<!-- <script type="text/javascript" src="js/tapmodo-Jcrop-1902fbc/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="js/tapmodo-Jcrop-1902fbc/css/jquery.Jcrop.min.css" type="text/css" />

<script>
  document.onkeydown = function(e) {
    console.log(1);
    if (e.keyCode == 116) {
      console.log(e);
    }
  };

  document.getElementById('image').onload = function() {
    var x = $.Jcrop('#image', {
      aspectRatio: 1,
      //trueSize: [400, 400],
      //trueSize: [$('#image')[0].naturalWidth, $('#image')[0].naturalHeight],
      onChange: changePreview,
      //onSelectEnd: setCoords,
      //onRelease: setCoords,
      keySupport: true
      // boxWidth: 400,
      // boxHeight: 400
      //onSelect: setCoords
    });

    console.log(x);

    //console.log($('#image')[0].naturalHeight);
  }

  function setCoords(selection) {
    var ratioW = $('#image')[0].naturalWidth / 400;
    var ratioH = $('#image')[0].naturalHeight / 400;

    console.log('sdasdasdasd');

    // $('input[name="x1"]').val(selection.x);
    // $('input[name="y1"]').val(selection.y);
    // $('input[name=w]').val(selection.w);
    // $('input[name=h]').val(selection.h);

    $('input[name="x1"]').val(selection.x * ratioW);
    $('input[name="y1"]').val(selection.y * ratioH);
    $('input[name=w]').val(selection.w * ratioW);
    $('input[name=h]').val(selection.h * ratioH);

    // $('input[name="x1"]').val(selection.x);
    // $('input[name="y1"]').val(selection.y);
    // $('input[name=w]').val(selection.w);
    // $('input[name=h]').val(selection.h);

    // $('#inner').trigger('click');
    // $('#inner').trigger('click');
  }

  function changePreview(selection) {
    if (!selection || !selection.w || !selection.h) {
      return;
    }

    var scaleX = 150 / (selection.w || 1);
    var scaleY = 150 / (selection.h || 1);

    $('#inner').css({
      width: Math.round( scaleX * $('#image').width() ) + 'px',
      height: Math.round( scaleY * $('#image').height() ) + 'px',
      marginLeft: '-' + Math.round(scaleX * selection.x) + 'px',
      marginTop: '-' + Math.round(scaleY * selection.y) + 'px'
    });

    console.log(121212);

    //setCoords(selection);
  }
</script> -->



<!-- imgAreaSelect -->

<!-- <link rel="stylesheet" type="text/css" href="js/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css" />
<script type="text/javascript" src="js/jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.pack.js"></script>

<script>
  document.getElementById('image').onload = function() {
    $('#image').imgAreaSelect({
      aspectRatio: "1:1",
      handles: true,
      //show: true,
      onSelectChange: changePreview,
      onSelectEnd: setCoords
    });
  }

  function setCoords(img, selection) {
    var ratioW = $('#image')[0].naturalWidth / 400;
    var ratioH = $('#image')[0].naturalHeight / 400;
    //var currentRatio = Math.min(ratioW, ratioH);

    $('input[name="x1"]').val(selection.x1 * ratioW);
    $('input[name="y1"]').val(selection.y1 * ratioH);
    $('input[name=w]').val(selection.width * ratioW);
    $('input[name=h]').val(selection.height * ratioH);

  }

  function changePreview(img, selection) {
    if (!selection.width || !selection.height) {
      return;
    }

    var scaleX = 150 / (selection.width || 1);
    var scaleY = 150 / (selection.height || 1);

    $('#inner').css({
      width: Math.round( scaleX * $('#image').width() ) + 'px',
      height: Math.round( scaleY * $('#image').height() ) + 'px',
      marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
      marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
  }
</script> -->






<!-- croppie (we will make it work later) -->

<!-- <link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.css">
<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.js"></script>

<script>
  document.getElementById('image').onload = function() {
    //var x;
    console.log(12);
    $('#parent').croppie({
      // viewport: {
      //   width: 400,
      //   height: 400
      // },
      boundary: {
        width: 300,
        height: 300
      },
      // points: [77, 469, 280, 739],
      url: $('#image').attr('src')
    });

    // 
    $('#parent').on('update.croppie', function(ev, cropData) {
      var x1 = cropData.points[0];
      var y1 = cropData.points[1];
      var x2 = cropData.points[2];
      var y2 = cropData.points[3];
      var h = y2 - y1;
      var w = x2 - x1;

      $('input[name="x1"]').val(x1);
      $('input[name="y1"]').val(y1);
      $('input[name=w]').val(w);
      $('input[name=h]').val(h);

      // cropped area data
      $('#parent').croppie('result', {}).then(function(x) {
        $('#inner').attr('src', x);
      })
    });
  }
</script> -->