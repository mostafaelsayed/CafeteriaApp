<?php
  require(__DIR__ . '/../layout.php');
?>

<title>Profile Info</title>

<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify/css/alertify.min.css">
<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify/css/themes/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify/css/themes/default.min.css">


<div class="container row">

  <!-- <h2>Profile Picture</h2> -->
  <div class="col-lg-4">
    <div style="margin-top: 70px">

      <img src="<?php echo $_SESSION['croppedImage']; ?>" />

      <br><br>

      
    </div>

    <div><button data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit" name="submit" value="Update">Update</button></div>

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

        <form enctype="multipart/form-data" method="post" action="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/User.php">
          <div style="text-align: center"><button class="btn btn-info" onclick="event.preventDefault();$('#file').trigger('click')">Choose Another Image</button></div>

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

            <div><img style="display: none" src="<?php echo $_SESSION['image']; ?>" id="myPic" /></div>

            <div id="container1">

              <div id="profPicture"></div>

              <div style="text-align: center" id="cont1">

                <img id="picInner" src="<?php echo $_SESSION['croppedImage']; ?>" />

              </div>

            </div>

          </div>

          <input type="hidden" name="x1" value="" />
          <input type="hidden" name="y1" value="" />
          <input type="hidden" name="w" value="" />
          <input type="hidden" name="h" value="" />
          <input type="hidden" name="update" value="1" />

          <br><br>
        
          <div style="text-align: center"><input type="submit" class="btn btn-primary" value="Update" /></div>
        </form>

      </div>

      <!-- <div class="modal-footer">

      </div> -->

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

<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/alertify/alertify.min.js"></script>

<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.css">
<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/node_modules/croppie/croppie.js"></script>

<script type="text/javascript" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/crop.js"></script>

<?php require(__DIR__ . '/../Public/footer.php'); ?>