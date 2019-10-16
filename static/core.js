//AutoInitialization of MaterialiseJS
M.AutoInit();

function showresult($message) {
    if(isJson($message)) {
        let obj = $.parseJSON($message);
        if(obj.classes.length > 0)
            M.toast({html: obj.message, classes: obj.classes, displayLength: 5500, outDuration: 700, inDuration: 550});
        else
            M.toast({html: obj.message, displayLength: 5500, outDuration: 700, inDuration: 550});
    }
    else {
        M.toast({html: $message, displayLength: 5500, outDuration: 700, inDuration: 550});
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

//ajax
$("#user_name").keyup(_.debounce(function (e) {
  if($(this).val().length > 5) {
    e.preventDefault();
    var fromData = {
      "action": "user_check",
      "user_name": $(this).val()
    };
    console.log(fromData);
    $.ajax({
        type:'post',
        url:'controller.php',
        data: fromData,
        success:function(result)
        {
            showresult(result);
        }
    });
  }
}, 1000));
