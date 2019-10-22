//AutoInitialization of MaterialiseJS
M.AutoInit();
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, options);
});

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

//Lets calculate user password score
$("#user_password").keyup(_.debounce(function (e) {
  if($(this).val().length > 5) {
    e.preventDefault();
    var pwscore = new Score($(this).val());
    pwscore = pwscore.calculateEntropyScore();
    if(pwscore < 400)
      showresult(JSON.stringify({message: "You'r password isn't safe!<br/> Please consider use stronger password!", classes: "rounded red darken-4"}));
    else if(pwscore >= 500 && pwscore < 800)
      showresult(JSON.stringify({message: "You'r password it's fine.<br/> In a future please consider improve your password.", classes: "rounded yellow darken-4"}));
    else
      showresult(JSON.stringify({message: "You'r password it's strong!", classes: "rounded green darken-4"}));
  }
  else
    showresult("You'r password should be at last 6 characters longer");
}, 700));

$("#user_password_confirm").keyup(_.debounce(function (e) {
  if($(this).val().length > 5) {
    e.preventDefault();
    if($("#user_password").val() === $(this).val())
      showresult(JSON.stringify({message: "Password mached!", classes: "rounded green darken-4"}));
    else
      showresult(JSON.stringify({message: "We can't match your password</br>Be sure you confirm your password!", classes: "rounded red darken-4"}));
    }
  }, 1000));
