
<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width" />
    <title>Adding Cafeteria</title>
    <script src="/CafeteriaApp.Frontend/Scripts/admin/adding cafeteria.js"></script>
  </head>

  <body>
    <div id="page-wrapper" style="margin-top:-600px">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Create Cafeteria</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">Adding New Cafeteria</div>

            <div class="panel-body">
              <div class="row">
    	           <div class="col-lg-6">
    		           <form role="form" ng-app="myapp" ng-controller="addCafeteria">
    			           <div class="form-group">
    				           <label>Name</label>
    				           <input type="text" class="form-control" autofocus="autofocus" ng-model="name" name="name" id="name" required/>
    			           </div>
    			           <div class="form-group" style="float: right">
    				           <button ng-click="addCafeteria()" class="btn btn-primary">Save</button>
                     </div>
    		           </form>
    	           </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

</html>
