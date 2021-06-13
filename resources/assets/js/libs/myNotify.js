const myNotify = {
    success: function(message){
        var icon = 'fa fa-check';
        var time = 1000;
        var type = 'success';
        myNotify.showNotify(type, icon, message, time);
    },
    err: function(message){
        var icon = 'fa fa-ban';
        var time = 1000;
        var type = 'danger';
        myNotify.showNotify(type, icon, message, time);
    },
    showNotify: function(type, icon, message, time){
        $.notify({
            icon: icon,
            message: message,
        }, {
            delay: time,
            type: type,
        });
    }
}

export default myNotify;