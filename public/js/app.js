function friend(name) {
    return {
        name: ko.observable(name)
    }
}

var vm = function () {
    var self = this;
    this.friends = ko.observableArray([new friend("Steve"), new friend("Frank"), new friend("Frank"), new friend("John")]);

    this.addFriend = function () {
        this.friends.push(new friend("Poop"));
        console.log(this);
    };

    this.deleteItem = function (y) {
        self.friends.remove(y);
    };

    this.updateItem = function (oldItem, newItem, pos) {
        for (var item of this.friends()) {
            if (item.name() == oldItem && this.friends().indexOf(item) == parseInt(pos)) {
                self.friends.replace(item, new friend(newItem));
                break;
            }
        }
        console.log(this.friends());
    };
}

$(document).ready(function () {
    var ViewModel = new vm();
    ko.applyBindings(ViewModel);
    $("#sortable").sortable();

    var origVal;
    $(".todoList").on('dblclick', '.todoText', function () {
        origVal = $(this).text();
        $(this).text("");
        $("<input type='text'>").appendTo(this).focus();
    });

    $(".todoList").on('focusout', '.todoText > input', function () {
        var $this = $(this);
        var newVal = $this.val().trim();
        var index = $this.parent().attr("index");
        //$this.parent().text($this.val() || origVal);
        if (newVal.length) {
            $this.parent().text(newVal);
            ViewModel.updateItem(origVal, newVal, index);
        }
        else {
            $this.parent().text(origVal);
        }
        $this.remove();
    });

});
