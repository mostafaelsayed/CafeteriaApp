
<!-- <ng-view></ng-view> -->
<title>Categories</title>
<?php
include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/admin/category.js"></script>
 <!-- <script src="/CafeteriaApp.Frontend/Scripts/admin/cafeteria.js"></script> -->
 <div id="page-wrapper" style="margin-top:-600px">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Cafeteria</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div ng-app="myapp">
<div ng-controller="editcafeteria" class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
               Edit Cafeteria
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" ng-model="Name" name="name" id="name" required>
                            </div>

                            <div class="form-group" style="float: right">
                                <button ng-click="editCafeteria()" class="btn btn-primary">Save</button>


                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Categories</h1>

    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row" ng-controller="getByCafeteriaId">
<!-- <script>
$("#mymodal").click(function(event){
    $(event.target).modal("hide");
});
</script> -->
 <script type="text/ng-template" id="modal.html">
         <div class="modal fade" id="mymodal" data-backdrop="false" style="background: rgba(0, 0, 0, 0.5)">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Are You Sure You Want To Delete This Cafeteria?</h4>
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
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Manage Your categories
                <div>
                    <a  style="float: right;margin-top: -23px;" title="Add Category" id="creatNewCategory" ng-click="gotocreatepage()"
                       class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-category">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="c in categories">
                        <tr class="odd gradeX">
                            <td ng-bind="c.Name"></td>

                            <td class="center">
                                <!-- <button type="button" id="myButton" data-bind="attr:{categoryid:Id,  name:Name}" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Delete</button> -->
                                <a id="myButton" ng-click="goToEditCategoryPage(c.Id)" class="btn btn-success">Edit</a>
                                <button href ng-click="deleteCategory(c.Id)" class="btn btn-danger">Delete</button>
                             </td>
                        </tr>

                    </tbody>
                    <tbody>
                        <tr ng-show="categories.length == 0">
                            <td colspan="5"> There are no records.</td>
                        </tr>
                    </tbody>
                </table>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
</div>
</div>
<!-- /.row -->


<!-- Modal -->
<!-- <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> -->

        <!-- Modal content-->
        <!-- <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Warning !!</h4>
            </div>
            <div class="modal-body">
                <p>Are You Sure You Want To Delete This Item?.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bind="click:deleteCategory">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>

    </div>
</div> -->
