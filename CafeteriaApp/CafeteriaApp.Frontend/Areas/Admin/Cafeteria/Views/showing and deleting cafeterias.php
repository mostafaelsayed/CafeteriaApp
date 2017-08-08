<title>Cafeterias</title>

<?php
 //require_once("CafeteriaApp.Backend/functions.php"); 
   //validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');



?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/showing and deleting cafeterias.js"></script>
<script src="/CafeteriaApp.Frontend/Scripts/admin/modal.js"></script>

<script src="/CafeteriaApp.Frontend/Scripts/CustomerTheme/modal.js"></script>

<div id="page-wrapper" style="margin-top:-600px">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Cafeterias</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp">
    <div ng-controller="showingAndDeletingCafeterias">
     <script type="text/ng-template" id="modal.html">
       <div class="modal fade" id="mymodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Are You Sure You Want To Delete This Cafeteria?</h4>
            </div>
            <div class="modal-body">
              <p>It's your call...</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" ng-click="close('No')" data-dismiss="modal">No</button>
              <button type="button" class="btn btn-primary" ng-click="close('Yes')" data-dismiss="modal">Yes</button>
            </div>
          </div>
        </div>
      </div>
     </script>
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Manage Your Cafeterias
            <div>
              <a style="float: right;margin-top: -23px;" title="Add Cafeteria" id="creatNewCafeteria" href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/adding cafeteria.php" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-cafeteria">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="c in cafeterias">
                <tr class="odd gradeX">
                  <td ng-bind="c.Name"></td>
                  <td class="center">
                    <a id="myButton" href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/editing cafeteria and showing and deleting its categories.php?id={{c.Id}}" class="btn btn-success">Edit</a>
                    <button type="button" ng-click="deleteCafeteria(c.Id)" class="btn btn-danger">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
