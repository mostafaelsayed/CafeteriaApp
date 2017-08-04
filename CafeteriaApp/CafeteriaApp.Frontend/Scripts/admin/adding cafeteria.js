function cafeteriaNewViewModel() {
  var self = this;
  ko.fileBindings.defaultOptions.buttonText = "Choose Image";
  self.fileData = ko.observable({
    base64String: ko.observable(),
    dataURL: ko.observable()
  });
}
