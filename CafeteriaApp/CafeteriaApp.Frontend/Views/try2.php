<!DOCTYPE html>
<html>
  <head>
    <title>AngularJS Services, shared varible btn controllers from a service</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0-beta.5/angular.min.js"></script>
  </head>
  <body>

  
   <div ng-app="app">
  <h1>Services</h1>

  <div ng-controller="ListCtrl as list">
    <p ng-repeat="message in list.messages">{{ message.id }}: {{ message.text }}</p>
  </div>


<div ng-controller="PostCtrl as post">
  <form ng-submit="post.addMessage(post.newMessage)">
    <input type="text" ng-model="post.newMessage">
    <button type="submit">Add Message</button>
  </form>
</div>
</div>
  </body>
</html>

<script type="text/javascript">
  
angular.module('app', []);

angular.module('app').factory('messages', function(){

});


angular.module('app').factory('messages', function(){
  var messages = {};

  messages.list = [];

  messages.add = function(message){
    messages.list.push({id: messages.list.length, text: message});
  };

  return messages;
});


angular.module('app').controller('ListCtrl', function (messages){
  var self = this;

  self.messages = messages.list;
});


angular.module('app').controller('PostCtrl', function (messages){
  var self = this;

  self.newMessage = 'Hello World!';

  self.addMessage = function(message){
    messages.add(message);
    self.newMessage = '';
  };
});

</script>