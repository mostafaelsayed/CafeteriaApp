<title>Managing Category</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/edit_category_and_show_and_delete_its_menuitems.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>

<script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">


<div>

  <div class="row">
    <div>
      <h1 class="page-header">Edit Category</h1>
    </div>
  </div>

  <div ng-app="myapp">
    <div>
      <div ng-controller="editCategory">
        <div>
          <div>
            <div>
              <div>
                <form novalidate role="form" name="myform" id="centerBlock">
                  <div class="form-group">
                    <label>Name</label>
                    <input id="inputField" type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required/>
                    <span ng-show="myform.name.$invalid" id="inputControl">Category Name is Required<br></span><br>
                    <div><label>Image</label></div>
                    <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                    </div>
                    <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                    <div ng-if="uploadme.src != ''">
                      <img ng-src="{{ uploadme.src }}" width="300" height="300">
                    </div>
                    <div ng-if="uploadme.src == ''">
                      <img ng-src="{{ imageUrl }}" width="300" height="300">
                    </div>
                    <br>
                    <button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label>
                  </div>
                  <div class="form-group">
                    <input type = "submit" value = "save" class="btn btn-primary" ng-click="editCategory()">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div>
        <h1 class="page-header">MenuItems</h1>
      </div>
    </div>

    
    <div class="row" ng-controller="showAndDeleteMenuItems">
      <script type="text/ng-template" id="modal.html">
         <div class="modal fade" id="mymodal" style="background: rgba(0, 0, 0, 0.5)">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Are You Sure You Want To Delete This Category?</h4>
               </div>
               <div class="modal-body">
                 <p>It's your call...</p>
               </div>
               <div class="modal-footer">
                 <button type="button" ng-click="close('No')" class="btn btn-default" data-dismiss="modal">No</button>
                 <button type="button" ng-click="close('Yes')" class="btn btn-primary" data-dismiss="modal">Yes</button>
               </div>
             </div>
           </div>
         </div>
      </script>

      <div>
        <div>
          <div><h3>Manage Your MenuItems</h3>
            <div>
              <a id="add" title="Add MenuItem" id="creatNewCategory" href="/CafeteriaApp.Frontend/Areas/Admin/MenuItem/Views/add_menuitem.php?id={{categoryId}}" target="_self" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div>
            <table width="50%" class="table table-bordered">
              <thead>
                <tr>
                  <th id="alignText">Name</th>
                  <th id="alignText">Price</th>
                  <th id="alignText">Description</th>
                  <th id="alignText">Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="m in menuItems">
                <tr class="odd gradeX">
                  <td id="alignText" ng-bind="m.Name"></td>
                  <td id="alignText" ng-bind="m.Price"></td>
                  <td id="alignText" ng-bind="m.Description"></td>
                  <td id="alignText" class="center">
                    <a id="myButton" href="/CafeteriaApp.Frontend/Areas/Admin/MenuItem/Views/edit_menuitem.php?id={{m.Id}}" target="_self">Edit</a>&nbsp;
                    <a style="cursor: pointer" ng-click="deleteMenuItem(m.Id)">Delete</a>
                  </td>
                </tr>
              </tbody>
              <tbody>
                <tr ng-show="menuItems.length == 0">
                  <td colspan="5" style="text-align: center"> There are no MenuItems in this Category.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>