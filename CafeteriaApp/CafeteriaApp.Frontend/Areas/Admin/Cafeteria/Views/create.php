
<?php
include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
 ?>
 <!-- <script src="/CafeteriaApp.Frontend/Scripts/admin/cafeteria.js"></script> -->
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Create Cafeteria</title>

    <script src="/CafeteriaApp.Frontend/Scripts/admin/cafeteria.js"></script>
</head>

<body>
  <!-- <script src="/CafeteriaApp.Frontend/Scripts/admin/layout.js"></script> -->
<div id="page-wrapper" style="margin-top:-600px">
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Create Cafeteria</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Adding New Cafeteria
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<form role="form" ng-app="myapp" ng-controller="addcafeteria">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" autofocus="autofocus" ng-model="Name" name="name" id="name" required/>
							</div>

				      <!-- <div ng-model="fileDrag: fileData">
								<div class="image-upload-preview">
									<img width="370" height="266" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
								</div>
								<div class="image-upload-input">
									<input type="file" data-bind="fileInput: fileData,customFileInput: {}">
								</div>
							</div> -->

							<div class="form-group" style="float: right">
								<button ng-click="addCafeteria()" class="btn btn-primary">Save</button>
								<!-- <button data-bind="click:cancel" class="btn btn-danger">Cancel</button> -->
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script> -->
</body>
</html>
