function listItem(name,check) {
    return {
        name: ko.observable(name),
        checked: ko.observable(check)
    }
}

var vm = function () {
    var self = this;
    //this.list = ko.observableArray([new listItem("Pick up Milk"), new listItem("Do Accounting Homework"), new listItem("Laundry"), new listItem("Call Mom")]);
    this.list = ko.observableArray();

    this.addItem = function (y,z) {
        this.list.push(new listItem(y,z));
    };

    this.deleteItem = function (y) {
        self.list.remove(y);
        self.saveData();
    };

    this.completeItem = function (index,i,item) {
        if (item.checked() == true){
            item.checked(false);
        } else {
            item.checked(true);
        }
        self.saveData();
    };

    this.updateItem = function (oldItem, newItem, pos) {
        for (var item of this.list()) {
            if (item.name() == oldItem && this.list().indexOf(item) == parseInt(pos)) {
                item.name(newItem);
                //self.list.replace(item, new this.list(newItem));
                self.saveData();
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
    LoadData(ViewModel);
    ko.applyBindings(ViewModel);
    $("#sortable").sortable({
        stop: function(event, ui) {
            ViewModel.saveData();
        }
    });

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

    $('.user-logout').click(function() {
        $.ajax({
            url: '/user/logout',
            type: 'POST',
            success: function (msg) {
                window.location = '/';
            },
            error: function (xhr, errormsg) {
                console.log('logout failed');
                //window.location = '/';
            }
        });
    });

});

function LoadData(vm) {
    var temp;
    $.ajax({
        url: '/data/load',
        data: {temp: temp},
        type: 'GET',
        success: function (msg) {
            temp = msg;
            assignData(temp,vm);
        },
        error: function (xhr, errormsg) {
            console.log(xhr);
            //window.location = '/';
        }
    });
}

function assignData(x,vm){
    var y = x.data.list;
    console.log(y[1].name);

    for (var i = 0; i < y.length; i++) {
        vm.addItem(y[i].name,y[i].checked);
    }
}
