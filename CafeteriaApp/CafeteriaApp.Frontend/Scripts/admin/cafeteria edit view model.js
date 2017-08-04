function cafeteriaEditViewModel() {

  var self = this;
  self.cafeteriaName = ko.observable();
  self.cafeteriaImage = ko.observable();
  self.chooseImageClicked = ko.observable(0);
  ko.fileBindings.defaultOptions.buttonText = "Choose Image";
  self.fileData = ko.observable({
    base64String: ko.observable(),
    dataURL: ko.observable()
  });

  var x = window.location.href;
  var id = parseInt(x.split("?id=")[1]);

  self.getCafeteria = function() {
    $.ajax({
      type: 'GET',
      url: '/CafeteriaApp.Backend/Requests/Cafeteria.php?id='+id,
      contentType: 'application/json'
    }).done(function(response){
      var data = JSON.parse(response);
      self.cafeteriaName(data.Name);
      self.cafeteriaImage(data.Image);
    }).fail(function(response){
      console.log(response);
    });
  }

  $("#file").on('change' , function() {
        self.chooseImageClicked(1);
  });

  self.getCafeteria();

  self.editCafeteria = function() {
    console.log(id);
    var data = {
      Id: id,
      Name: self.cafeteriaName(),
      Image: self.fileData().base64String()
    };
    $.ajax({
      type: 'PUT',
      url: '/CafeteriaApp.Backend/Requests/Cafeteria.php',
      contentType: 'application/json; charset=utf-8',
      data: JSON.stringify(data)
    }).done(function(response){
      console.log(response);
      //self.getCafeteria();
      window.history.back();
      // var data = JSON.parse(response);
      // self.cafeteriaName(data.Name);
      // self.cafeteriaImage(data.Image);
    }).fail(function(response){
      console.log(response);
    });
   }
}
