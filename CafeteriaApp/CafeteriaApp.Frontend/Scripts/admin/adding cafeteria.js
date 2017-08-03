function cafeteriaNewViewModel() {
  var self = this;
  ko.fileBindings.defaultOptions.buttonText = "Choose Image";
  self.fileData = ko.observable({
    base64_string: ko.observable(),
    dataURL: ko.observable()
  });
  console.log(self.fileData());
}
