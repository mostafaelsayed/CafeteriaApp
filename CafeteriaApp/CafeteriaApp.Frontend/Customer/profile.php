<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([2]);
?>

<title>Profile Info</title>

<link rel="stylesheet" type="text/css" href="/js/alertify/css/alertify.min.css">
<link rel="stylesheet" type="text/css" href="/js/alertify/css/themes/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/js/alertify/css/themes/default.min.css">
<!-- <link rel="stylesheet" href="/js/bower_components/fakeLoader/fakeLoader.css"> -->

<meta charset="utf-8" id="imgFlag" value="<?php echo $_SESSION['imgFlag'] ?>">

<div ng-controller="profile">

<div class="container row">

  <!-- <h2>Profile Picture</h2> -->
  <div class="col-lg-4">
    <div style="margin-top: 70px">

      <img style="width: 150px;height: 150px" id="cropped" src="<?php echo $_SESSION['croppedImage']; ?>" />

      <br><br>

    </div>

    <div><button data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit" name="submit" value="Update">Update</button></div>
    <br><br>

    <button ng-click="delete()" class="btn btn-primary" type="submit">Delete</button>

  </div>

</div>

<div id="myModal" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">Change Profile Photo</h4>

      </div>

      <div class="modal-body">

        <form name="myform" method="post">
          <div style="text-align: center"><button class="btn btn-info" onclick="event.preventDefault();$('#file').trigger('click')">Choose Another Image</button></div>

          <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" id="csrf_token">

          <img style="display: none" id="myimg" src="">

          <input type="file" id="file" name="image" class="inputfile" value="" onchange="readURL(this)" />

          <div id="y">
            <div id="container">

              <div id="parent"></div>

              <br>

              <div id="cont">

                <img id="inner" />

              </div>

            </div>
          </div>

          <div id="x">

            <div id="profPicture"></div>

            <div><img style="display: none;" src="<?php echo $_SESSION['image']; ?>" id="myPic" /></div>

            <div id="container1">

              <div id="profPicture"></div>

              <div style="text-align: center" id="cont1">

                <img id="picInner" src="<?php echo $_SESSION['croppedImage']; ?>" />

              </div>

            </div>

          </div>

          <input type="hidden" name="x1" id="x1" value="" />
          <input type="hidden" name="y1" id="y1" value="" />
          <input type="hidden" name="w" id="w" value="" />
          <input type="hidden" name="h" id="h" value="" />

          <br><br>
        <!-- ng-show="<?php echo $_SESSION['imgFlag'] ?> != 1" -->
          <div style="text-align: center"><input type="submit" class="btn btn-primary" ng-click="updateImage()" /></div>
        </form>        

      </div>

      <!-- <div class="modal-footer">

      </div> -->

    </div>

  </div>

</div>

</div>

<style type="text/css">
  input[type=file] {
    opacity: 0;
    /*position: absolute;*/
    max-width: 10px;
    top: 0;
  }

  #picInner {
    width: 150px;
    height: 150px
  }

  /* preview container */
  #cont {
    width: 150px;
    height: 150px;
    /*overflow: hidden;*/
    /*float: right;*/
    text-align: center;
    margin: 0 auto;
    /*position: relative*/
  }

  /* preview */
  #inner {
    /*margin: 0 auto;*/
    /*min-height: 100%;
    min-width: 100%*/
    text-align: center;
  }

  /* original image */
  #image {
    margin: 0 auto;
    /* Don't set max-height and max-width */
    /*max-width: 100%;
    max-height: 100%;*/
    width: 400px;
    height: 400px;
  }
</style>

<script type="text/javascript" src="/js/alertify/alertify.min.js"></script>

<link rel="stylesheet" type="text/css" href="/js/node_modules/croppie/croppie.css">
<script type="text/javascript" src="/js/node_modules/croppie/croppie.js"></script>
<script type="text/javascript" src="/js/crop.js"></script>
<!-- <script type="text/javascript" src="/js/bower_components/fakeLoader/fakeLoader.min.js"></script> -->
<script type="text/javascript" src="/js/profile.js"></script>

<!-- <script type="text/javascript">
  function readURL(input) {
    var file = input.files[0];

    if (input.files && file) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#image').attr('src', e.target.result);
      };

      reader.readAsDataURL(file);
    }
  }
</script> -->

<?php require(__DIR__ . '/../Public/footer.php'); ?>