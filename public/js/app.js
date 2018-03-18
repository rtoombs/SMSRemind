function listItem(name) {
    return {
        name: ko.observable(name),
        checked: ko.observable(false)
    }
}

var vm = function () {
    var self = this;
    this.list = ko.observableArray([new listItem("Pick up Milk"), new listItem("Do Accounting Homework"), new listItem("Laundry"), new listItem("Call Mom")]);

    this.addItem = function (y) {
        this.list.push(new listItem(y));
    };

    this.deleteItem = function (y) {
        self.list.remove(y);
    };

    this.completeItem = function (index,i,item) {
        if (item.checked() == true){
            item.checked(false);
        } else {
            item.checked(true);
        }
    };

    this.updateItem = function (oldItem, newItem, pos) {
        for (var item of this.list()) {
            if (item.name() == oldItem && this.list().indexOf(item) == parseInt(pos)) {
                item.name(newItem);
                //self.list.replace(item, new this.list(newItem));
                break;
            }
        }
    };

    this.saveData = function () {
        var jsonData = ko.toJS(self);
        $.ajax({
            url: '/data/update',
            data: {data: ko.toJSON(jsonData)},
            type: 'POST',
            success: function (msg) {
                console.log('Successfully Saved Data to Server!');
            },
            error: function (xhr, errormsg) {
                console.log('Boo! Something Went Wrong!');
                //window.location = '/';
            }
        });

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
        else { $this.parent().text(origVal);}
        $this.remove();
    });

    $('.add-new-item').click(function() {
        var title = $('.newItemTitle').val().trim();
        if (title.length > 0) {
            ViewModel.addItem(title);
            $('.newItemTitle').val('');
            $('#addNewItem').modal('hide');
            ViewModel.saveData();
        }
    });

    $(".newItemTitle").on('keyup focusout', function() {
        var x = $('.newItemTitle').val().trim();
        if (x.length > 0 && x != null) {
            $('.add-new-item').removeClass('disabled');
        } else {
            $('.add-new-item').addClass('disabled');
        }
    });

});

function SaveData() {
    var jsonData = ko.toJS(this.vm);
    console.log(jsonData);
}
