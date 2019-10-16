//AutoInitialization of MaterialiseJS
M.AutoInit();

function showresult($message) {
    if(isJson($message)) {
        let obj = $.parseJSON($message);
        if(obj.classes.length > 0)
            M.toast({html: obj.message, classes: obj.classes});
        else
            M.toast({html: obj.message});
    }
    else {
        M.toast({html: $message});
    }
}

//Loading state for ajax
$(document).ajaxStart(function () {
    $("#loading").show("slow");
}).ajaxStop(function () {
    $("#loading").hide("slow");
});

function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}
