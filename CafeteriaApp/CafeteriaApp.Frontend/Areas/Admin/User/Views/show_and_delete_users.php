<title>Users</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');

?>

<script src="/CafeteriaApp.Frontend/javascript/show_and_delete_users.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>

<script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

<div>

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Users</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp">
    <div ng-controller="showAndDeleteUsers">
     <script type="text/ng-template" id="modal.html">
       <div class="modal fade" id="mymodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Are You Sure You Want To Delete This User?</h4>
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
        <div style="margin: auto">
          <div><h3 >Manage Your Users</h3>
            <div>
              <a id="add" title="Add Users" id="creatNewCafeteria" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/add_user.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div>
            <table width="50%" class="table" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr>
                  <th id="alignText">User Name</th>
                  <th id="alignText">Email</th>
                  <th id="alignText">Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="u in users">
                <tr>
                  <td id="alignText" ng-bind="u.UserName"></td>
                  <td id="alignText" ng-bind="u.Email"></td>
                  <td id="alignText" class="center">
                    <a type="button" href="/CafeteriaApp.Frontend/Areas/Admin/User/Views/edit_user.php?id={{u.Id}}">Edit</a>&nbsp;&nbsp;
                    <a type="button" style="cursor: pointer" ng-click="deleteUser(u)">Delete</a>
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
