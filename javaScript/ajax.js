$(document).ready(function () {
  $("#btn_sign-in").click(function () {
    sendAjaxForm("sign_in", "signIn.php");
    return false;
  });
  $("#btn_sign-up").click(function () {
    sendAjaxForm("sign_up", "signUp.php");
    return false;
  });
  $("#btn_edit").click(function () {
    sendAjaxForm("form", "editInformationUsers.php");
    return false;
  });
});

function sendAjaxForm(ajax_form, url) {
  $.ajax({
    url: url,
    type: "POST",
    dataType: "html",
    data: $("." + ajax_form).serialize(),
    success: function (response) {
      result = $.parseJSON(response);
      if (result.res == true) {
        location.reload();
      } else {
        $(".err").html(result.error);
        $(".errName").html(result.errorName);
        $(".errEmail").html(result.errorEmail);
        $(".errLogin").html(result.errorLogin);
        $(".errPassword").html(result.errorPassword);
      }
    },
    error: function (response) {
      console.log("BAD");
      $("#fatal_error").html("Ошибка. Данные не отправлены.");
    },
  });
}
