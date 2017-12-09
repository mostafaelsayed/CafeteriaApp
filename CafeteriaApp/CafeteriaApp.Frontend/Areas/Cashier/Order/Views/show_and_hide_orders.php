<title>Orders</title>

<?php
  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/functions.php'); 
  validatePageAccess($conn);
  require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Cashier/layout.php');
?>

<head>
  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/show_and_hide_orders.js"></script>
  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>
  <script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/modal.js"></script>
</head>

<div>

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Orders</h1>
    </div>
  </div>

  <div class="row">
    <div ng-app="cashierApp" ng-controller="showAndHideOrders" ng-cloak>
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
          <div><h3>Manage Your Orders</h3>
            <div>
              <a id="add" title="Add Order" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Customer/Cafeteria/Views/showing cafeterias.php" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div>
            <table width="50%" class="table" style="border-collapse: collapse" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr>
                  <th id="alignText">Id</th>
                  <th id="alignText">Type</th>
                  <th id="alignText">Status</th>
                  <th id="alignText">Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="o in orders">
                <tr>
                  <td id="alignText" ng-bind="o.Id"></td>
                  <td id="alignText" ng-show="o.Type == 1">Delivery</td>
                  <td id="alignText" ng-show="o.Type == 0">Take Away</td>
                  <td id="alignText" ng-show="o.OrderStatusId == 1">Open</td>
                  <td id="alignText" ng-show="o.OrderStatusId == 2">Closed</td>
                  <td id="alignText" class="center">
                    <a type="button" style="cursor: pointer" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Cashier/Order/Views/edit_order.php?id={{o.Id}}">Edit</a>&nbsp;&nbsp;
                    <a type="button" style="cursor: pointer" ng-click="hideOrder(o)">Hide</a>&nbsp;&nbsp;
                    <a class="btn btn-info" style="cursor: pointer" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Cashier/Order/Views/show_order_details.php?id={{o.Id}}">Show Details</a>
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
?>