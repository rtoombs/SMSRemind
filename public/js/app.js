function friend(name) {
    return {
        name: ko.observable(name)
    }
}

var viewModel = function(){
    var self = this;
    this.firstName = ko.observable("Riley");
    this.lastName = ko.observable("Toombs");
    this.friends = ko.observableArray([new friend("Steve"), new friend("Tom"),new friend("Frank"),new friend("John")]);

    this.addFriend = function() {
        console.log(this);
        this.friends.push(new friend("Poop"));
    };

    this.deleteItem = function(y) {
        self.friends.remove(y);
        console.log(self.friends());
    };
}


$( document ).ready(function() {
    ko.applyBindings(new viewModel());
    $( "#sortable" ).sortable();
});