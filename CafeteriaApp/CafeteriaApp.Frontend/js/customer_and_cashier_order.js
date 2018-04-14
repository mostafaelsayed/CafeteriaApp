angular.module('customer_and_cashier_order', []).factory('Order_Info', ['$interval', '$http', '$rootScope', '$timeout', function($interval, $http, $rootScope, $timeout) {
    var order_info = {};
    order_info.orderId = '';
    order_info.ShowHides = [];
    order_info.add_edits = [];
    order_info.commentDetails = [];
    order_info.comments = [];
    order_info.customerCommentsIds = [];
    order_info.commentIndex = '';
    order_info.ratedMenuItemsIds = [];
    order_info.ItemRating = [];
    order_info.getOrderItems = function(orderId) { // this is asyhnchronous
        $http.get('../../CafeteriaApp.Backend/Requests/OrderItem.php?orderId=' + orderId).success(function(data) {
            //console.log(data);
            $rootScope.orderItems = data;
            order_info.orderId = orderId;
        });
    };
    order_info.toggleFavoriteItem = function(menuItemId) {
        var data = {
            menuItemId: menuItemId
        };
        //data = JSON.stringify(data);
        var color = $('#favorites' +menuItemId).css('color');
        if (color == "red" || color=='rgb(255, 0, 0)') { // add favorite
            $http.post('../../CafeteriaApp.Backend/Requests/FavoriteItem.php', data).then(function(response) {
                if (response.data !== "") {
                    alertify.error(response.data);
                } else {
                    document.getElementById('favorites' + menuItemId).style.color = "yellow";
                    order_info.togglePopup('favorite Item added successfully !');
                }
            });
        } else {
            $http({
                method: 'DELETE',
                url: '../../CafeteriaApp.Backend/Requests/FavoriteItem.php',
                data: data,
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            }).then(function(response) {
                //console.log(response.data);
                if (response.data == 0) {
                    document.getElementById("favorites" + menuItemId).style.color = "red";
                    alertify.success('favorite Item removed successfully !');
                    
                } else {
                    alertify.error('Error occured !');
                }
            });
        }
    }
    order_info.addToOrder = function(menuItemId) {
        var x = $rootScope.orderItems.filter(function(o) {
            return o.MenuItemId == menuItemId
        });
        if (x.length > 0) {
            order_info.increaseQuantity(x[0]); // we extract the first element because x is array (x must be one length array)
        } else {
            var data = {
                OrderId: order_info.orderId,
                MenuItemId: menuItemId,
                Quantity: 1
            };
            $http.post('../../CafeteriaApp.Backend/Requests/OrderItem.php', data).then(function(response) {
                //console.log(response);
                order_info.orderId = response.data;
                order_info.togglePopup('OrderItem added successfully !');
                order_info.getOrderItems(order_info.orderId);
            });
        }
    };
    order_info.togglePopup = function(message) {
        var popup = document.getElementById("myPopup");
        popup.innerHTML = message;
        popup.classList.toggle("show");
        $timeout(function() {
            popup.classList.toggle("show");
        }, 2000);
    };
    order_info.increaseQuantity = function(orderItem) {
        if (orderItem.OrderId != null) {
            var data = {
                Id: orderItem.Id,
                Quantity: parseInt(orderItem.Quantity) + 1
            };
            $http.put('../../CafeteriaApp.Backend/Requests/OrderItem.php', data).then(function(response) {
                order_info.getOrderItems(orderItem.OrderId);
                order_info.togglePopup('OrderItem added successfully  !');
            });
        }
    };
    order_info.decreaseQuantity = function(orderItem) {
        var data = {
            Id: orderItem.Id,
            Quantity: parseInt(orderItem.Quantity) - 1
        };
        if (orderItem.Quantity > 1) {
            $http.put('../../CafeteriaApp.Backend/Requests/OrderItem.php', data).then(function(response) {
                order_info.getOrderItems(orderItem.OrderId);
                order_info.togglePopup('OrderItem removed successfully !');
            });
        } else {
            order_info.deleteOrderItem(orderItem);
        }
    };
    order_info.deleteOrderItem = function(orderItem) {
        $http.delete('../../CafeteriaApp.Backend/Requests/OrderItem.php?id=' + orderItem.Id).then(function(response) {
            order_info.getOrderItems(orderItem.OrderId);
            order_info.togglePopup('OrderItem removed successfully !');
        });
    };
    order_info.initializeMenuItemCommmentFlags = function(scope) {
        for (var i = 0; i < scope.menuItems.length; i++) {
            order_info.ShowHides.push(false);
            order_info.add_edits.push(true);
            order_info.commentDetails.push("");
        }
    };
    order_info.getCurrentDate = function() {
        var today = new Date();
        var dd = today.getDate(); // get day
        var mm = today.getMonth() + 1; // January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        return yyyy + '/' + mm + '/' + dd; // to work with db format
    };
    order_info.loadCommentsforMenuItem = function(menuItemId, menuItemIndex) {
        $http.get('../../CafeteriaApp.Backend/Requests/Comment.php?MenuItemId=' + menuItemId).then(function(response) {
            //console.log(response);
            order_info.comments[menuItemIndex] = response.data[0];
            order_info.customerCommentsIds[menuItemIndex] = response.data[1];
        });
    };
    order_info.toggleMenuItemComments = function(menuItemIndex, menuItemId) {
        order_info.ShowHides[menuItemIndex] = !order_info.ShowHides[menuItemIndex];
        if (order_info.ShowHides[menuItemIndex]) {
            order_info.loadCommentsforMenuItem(menuItemId, menuItemIndex);
        }
    };
    order_info.addCommentBackAndFront = function(menuItemIndex, menuItemId, commentDetails, CustomerName, add_update, userImage) {
        if (order_info.commentDetails[menuItemIndex] !== "") { // check empty box doesn't work
            if (add_update) {
                var date = order_info.getCurrentDate();
                var data = {
                    Details: commentDetails,
                    MenuItemId: menuItemId,
                    Date: date
                };
                $http.post('../../CafeteriaApp.Backend/Requests/Comment.php', data).then(function(response) { //response.data=id of new comment
                    if (response.data !== "") {
                        order_info.customerCommentsIds[menuItemIndex].push(response.data);
                        order_info.comments[menuItemIndex].push({
                            UserName: CustomerName,
                            Date: date,
                            Details: commentDetails,
                            Id: response.data,
                            Image: userImage
                        });
                    } else {
                        alertify.error(response.data);
                    }
                });
            } else { //update
                order_info.updateCommentBackAndFront(menuItemIndex, menuItemId, commentDetails);
            }
            order_info.commentDetails[menuItemIndex] = "";
        }
    };
    order_info.updateCommentBackAndFront = function(menuItemIndex, menuItemId, commentDetails) {
        var date = order_info.getCurrentDate();
        var data = {
            Details: commentDetails,
            Id: order_info.comments[menuItemIndex][order_info.commentIndex].Id,
        };
        $http.put('../../CafeteriaApp.Backend/Requests/Comment.php', data).then(function(response) { // response.data=id of new comment
            if (response.data !== "") {
                alertify.error(response.data);
            } else { //update page content
                order_info.comments[menuItemIndex][order_info.commentIndex].Details = commentDetails;
                order_info.comments[menuItemIndex][order_info.commentIndex].Date = date;
                document.getElementById('addUpdateBtn' + menuItemIndex).value = 'Add';
                order_info.add_edits[menuItemIndex] = true;
            }
        });
    };
    order_info.editComment = function(commentIndex, menuItemIndex) {
        order_info.commentIndex = commentIndex;
        order_info.toggleUpdateAddButton(menuItemIndex, order_info.comments[menuItemIndex][commentIndex].Details);
    };
    order_info.toggleUpdateAddButton = function(menuItemIndex, commentDetails) {
        order_info.commentDetails[menuItemIndex] = commentDetails;
        if (order_info.add_edits[menuItemIndex]) {
            document.getElementById('addUpdateBtn' + menuItemIndex).value = 'Update';
            order_info.add_edits[menuItemIndex] = false;
        }
    };
    order_info.deleteComment = function(commentId, commentIndex, menuItemIndex) {
        if (order_info.add_edits[menuItemIndex]) { // only if not in edit mode
            $http.delete('../../CafeteriaApp.Backend/Requests/Comment.php?id=' + commentId).then(function(response) {
                if (response.data != "") {
                    alertify.error(response.data);
                } else {
                    order_info.customerCommentsIds[menuItemIndex].splice(order_info.customerCommentsIds[menuItemIndex].indexOf(order_info.comments[menuItemIndex][commentIndex].Id), 1);
                    order_info.comments[menuItemIndex].splice(commentIndex, 1);
                }
            });
        }
    };
    order_info.checkEditAndRemove = function(commentId, index) {
        return $.inArray(commentId, order_info.customerCommentsIds[index]) === -1 ? false : true;
    }
    order_info.loadRatedMenuItemsForUser = function(scope) {
        $http.get('../../CafeteriaApp.Backend/Requests/Rating.php').then(function(response) {
            order_info.ratedMenuItemsIds = response.data[1]; // for updating 
            for (var j = 0; j < scope.menuItems.length; j++) {
                for (var i = 0; i < response.data[0].length; i++) {
                    if (scope.menuItems[j].Id === response.data[0][i][0]) {
                        order_info.ItemRating[j] = response.data[0][i][1]; // get the value of rating for item of index j
                    }
                }
            }
        });
    };
    order_info.checkaddUpdateRating = function(MenuItemId) {
        return $.inArray(MenuItemId, order_info.ratedMenuItemsIds) === -1 ? false : true;
    };
    order_info.addRatingOrUpdate = function(MenuItemId, value, scope) {
        if (order_info.checkaddUpdateRating(MenuItemId)) { // update
            var data = {
                MenuItemId: MenuItemId,
                Value: value
            };
            $http.put('../../CafeteriaApp.Backend/Requests/Rating.php', data).then(function(response) {
                if (response.data !== "") {
                    order_info.togglePopup('Item rateing updated successfully !');
                } else {}
            });
        } else {
            var data = {
                MenuItemId: MenuItemId,
                Value: value
            };
            $http.post('../../CafeteriaApp.Backend/Requests/Rating.php', data).then(function(response) {
                if (response.data !== "") {
                    order_info.ratedMenuItemsIds.push(MenuItemId);
                    for (var i = scope.menuItems.length - 1; i >= 0; i--) {
                        if (scope.menuItems[i].Id == MenuItemId) {
                            scope.menuItems[i].RatingUsersNo++;
                        }
                    }
                    order_info.togglePopup('Item rateing added successfully !');
                } else {}
            });
        }
    };
    return order_info;
}]);