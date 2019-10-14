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

//Anime Page MD
if($("#u_com_anime").length) {
    var s1 = new SimpleMDE({ element: $("#u_com_anime")[0], spellChecker: false, promptURLs: true });
}


//AJAX Autoload
$("#admin_interface").one("click", function(){
    $.getScript("js/plugins/admin_usermanager.js");
});

$(".modal_auth").one("click", function(){
    $.getScript("js/plugins/login.js");
});

$(".menu_newreq").one("click", function(){
    $.getScript("js/plugins/menu_addrequest.js");
});

$(".btn_reg").one("click", function(){
    var regloaded = false;
    if (typeof window.regloaded == 'undefined') {
        $.getScript("js/plugins/register.js");
    }
});

$(".btn_profil").one("click", function(){
    $.getScript("js/plugins/profile.js");
});

$("#requestsection").one("mouseover", function(){
    $.getScript("js/plugins/addrequest.js");
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