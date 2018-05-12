layoutApp.controller('getMenuItemsAndCustomerOrder', ['$rootScope', '$scope', '$http', 'Order_Info',
	function($rootScope, $scope, $http, Order_Info) {
		$scope.data = Order_Info;

		$http.get('/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Requests/search.php').then(function(response) {
			$scope.menuItems = response.data;
			console.log(response);
		});

		$scope.addToOrder = function(menuItem) {
	    	Order_Info.addToOrder(menuItem);
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

		$scope.addCommentBackAndFront = function(menuItemIndex, menuItemId, commentDetails, CustomerName, add_update) {
			Order_Info.addCommentBackAndFront(menuItemIndex, menuItemId, commentDetails, CustomerName, add_update);
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

		$scope.commentDetails = [];//menuitems
		$scope.add_edits = [];//menuitems
		$scope.ShowHides = [];//menuitems
		$scope.comments = [];//menuitems
		$scope.customerCommentsIds = [];//menuitems
		$scope.ItemRating = [];
}]);