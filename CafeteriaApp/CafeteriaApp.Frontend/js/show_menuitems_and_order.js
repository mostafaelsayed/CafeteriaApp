//***try use arguments instead of mentioning all items

// controller for getting menuitems of a category from database
layoutApp.controller('getMenuItemsAndCustomerOrder', ['$scope', '$http', '$rootScope', '$timeout', 'Order_Info'
, function($scope, $http, $rootScope, $timeout, Order_Info) {
  $scope.data = Order_Info;

  if (localStorage.getItem("discard") == 1) {
    localStorage.setItem("discard", 0);
    alertify.success('Order Discarded');
  }

  $scope.categoryName = $.urlParam(0);
  $scope.categoryId = 0;

  $scope.getCategoryIdByName = function() {
    $http.get('/myapi/Category/name/' + $scope.categoryName).then(function(response) {
      $scope.categoryId = parseInt(response.data);
      $scope.getMenuItems();
      console.log(response);
    })
  };

  $scope.getCategoryIdByName();

  $scope.checkUser = function() {
    $http.get('/myapi/User/flag/1')
    .then(function(response) {
      if (response.data == 3) { // cahsier then return to his page of orders
        $scope.roleid = true;
      }
      else {
        $scope.roleid = false;
      }
    });
  };

  $scope.checkUser();
  
  $scope.getMenuItems = function() {
    console.log($scope.categoryId);
    $http.get('/myapi/MenuItem/categoryId/' + $scope.categoryId)
    .then(function(response) {
      console.log(response);
      $scope.menuItems = response.data;
      $scope.loadFavoriteItems();
      $scope.initializeMenuItemCommmentFlags();
      $scope.loadRatedMenuItemsForUser();
    });
  };

  $scope.addToOrder = function(menuItemId) {
    Order_Info.addToOrder(menuItemId);
  };

  $scope.increaseQuantity = function(OrderItem) {
    Order_Info.increaseQuantity(OrderItem);
  };

  $scope.decreaseQuantity = function(OrderItem) {
    Order_Info.decreaseQuantity(OrderItem);
  };

  $scope.deleteOrderItem = function(OrderItem) {
    Order_Info.deleteOrderItem(OrderItem);
  };

  $scope.toggleFavoriteItem = function(menuItemId) {
    Order_Info.toggleFavoriteItem(menuItemId);
  };

  $scope.loadFavoriteItems = function() {
    $http.get('/myapi/FavoriteItem')
    .then(function(response) {
      $scope.favoItems = response.data;

      for (var i = 0; i < $scope.menuItems.length; i++) {
        for (var j = 0; j < $scope.favoItems.length; j++) {   
          if ($scope.menuItems[i].Id == $scope.favoItems[j].MenuItemId) {
            document.getElementById('favorites' + $scope.menuItems[i].Id).style.color = "yellow";
          }
        }
      }
    });
  };

  $scope.initializeMenuItemCommmentFlags = function() {
    Order_Info.initializeMenuItemCommmentFlags($scope);
  };

  $scope.getCurrentDate = function() {
    Order_Info.getCurrentDate();
  };

  $scope.loadCommentsforMenuItem = function(menuItemId, menuItemIndex) {
    Order_Info.loadCommentsforMenuItem(menuItemId, menuItemIndex);
  };

  $scope.toggleMenuItemComments = function(menuItemIndex, menuItemId) {
    Order_Info.toggleMenuItemComments(menuItemIndex, menuItemId);
  };

  $scope.addCommentBackAndFront = function(menuItemIndex, menuItemId, commentDetails, CustomerName, add_update,userImage) {
    Order_Info.addCommentBackAndFront(menuItemIndex, menuItemId, commentDetails, CustomerName, add_update, userImage);
  };

  $scope.updateCommentBackAndFront = function(menuItemIndex, menuItemId, commentDetails) {
    Order_Info.updateCommentBackAndFront(menuItemIndex, menuItemId, commentDetails);
  };

  $scope.editComment = function(commentIndex, menuItemIndex) {
    Order_Info.editComment(commentIndex, menuItemIndex);
  };

  $scope.toggleUpdateAddButton = function(menuItemIndex, commentDetails) {
    Order_Info.toggleUpdateAddButton(menuItemIndex, commentDetails);
  };

  $scope.deleteComment = function(commentId, commentIndex, menuItemIndex) {
    Order_Info.deleteComment(commentId, commentIndex, menuItemIndex);
  };

  $scope.checkEditAndRemove = function(commentId, index) {
    Order_Info.checkEditAndRemove(commentId, index);   
  }

  $scope.loadRatedMenuItemsForUser = function() {
    Order_Info.loadRatedMenuItemsForUser($scope);
  };

  $scope.checkaddUpdateRating = function(MenuItemId) {
    Order_Info.checkaddUpdateRating(MenuItemId);
  };

  $scope.addRatingOrUpdate = function(MenuItemId, value) {
    Order_Info.addRatingOrUpdate(MenuItemId, value, $scope);
  };

  var self = this;

  $scope.commentDetails = [];//menuitems
  $scope.add_edits = [];//menuitems
  $scope.ShowHides = [];//menuitems
  $scope.comments = [];//menuitems
  $scope.customerCommentsIds = [];//menuitems
  $scope.ItemRating = [];
  
}]);