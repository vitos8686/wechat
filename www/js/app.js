ons.bootstrap()
  .controller('SplitterController', function() {
    this.load = function(page) {
      mySplitter.content.load(page)
        .then(function() {
          mySplitter.left.close();
        });
    };
  });