<title>Orders</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
  //validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Cashier/layout.php');

?>

<head>

  <script src="/CafeteriaApp.Frontend/javascript/show_and_hide_orders.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>
  <script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

</head>


<div>

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header" style="color: white">Orders</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp">
    <div ng-controller="showAndHideOrders">
     <script type="text/ng-template" id="modal.html">
       <div class="modal fade" id="mymodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Are You Sure You Want To Hide This Order? it will no longer be visible to you</h4>
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
          <div><h3 style="color: white">Manage Your Orders</h3>
            <div>
              <a id="add" title="Add Order" href="/CafeteriaApp.Frontend/Areas/Customer/Cafeteria/Views/showing cafeterias.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div>
            <table width="50%" class="table" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr>
                  <th id="alignText" style="color: white">Id</th>
                  <th id="alignText" style="color: white">Type</th>
                  <th id="alignText" style="color: white">Status</th>
                  <th id="alignText" style="color: white">Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="o in orders">
                <tr>
                  <td id="alignText" style="color: white" ng-bind="o.Id"></td>
                  <td id="alignText" style="color: white" ng-show="o.Type == 1">Delivery</td>
                  <td id="alignText" style="color: white" ng-show="o.Type == 0">Take Away</td>
                  <td id="alignText" style="color: white" ng-show="o.OrderStatusId == 1">Open</td>
                  <td id="alignText" style="color: white" ng-show="o.OrderStatusId == 2">Closed</td>
                  <td id="alignText" style="color: white" class="center">
                    <a type="button" style="cursor: pointer" ng-click="editOrder(o)">Edit</a>&nbsp;&nbsp;
                    <a type="button" style="cursor: pointer" ng-click="hideOrder(o)">Hide</a>&nbsp;&nbsp;
                    <button class="btn btn-info" style="cursor: pointer" ng-click="showPlace(o)">Show Delivery Place in Map</button>
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
<?php require_once("CafeteriaApp.Frontend/Areas/footer.php");
?>