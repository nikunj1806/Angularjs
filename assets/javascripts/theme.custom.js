/* Add here all your JS customizations */

function notification(msg, type) {
    var n = noty({layout: 'center',
        type: type,
        text: msg, // can be html or string
        timeout: 2000,
    });
}

function stickynotification(msg, type) {
    var n = noty({layout: 'center',
        type: type,
        text: msg // can be html or string    
    });
}