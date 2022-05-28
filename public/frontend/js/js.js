const rmCheckCustomer = document.getElementById("rememberCustomer"),
    emailInputCustomer = document.getElementById("emailCustomer");

if (localStorage.checkbox && localStorage.checkbox !== "") {
  rmCheckCustomer.setAttribute("checked", "checked");
  emailInputCustomer.value = localStorage.username;
} else {
  rmCheckCustomer.removeAttribute("checked");
  emailInputCustomer.value = "";
}

function lsRememberCustomer() {
  if (rmCheckCustomer.checked && emailInputCustomer.value !== "") {
    localStorage.username = emailInputCustomer.value;
    localStorage.checkbox = rmCheckCustomer.value;
  } else {
    localStorage.username = "";
    localStorage.checkbox = "";
  }
}

$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});



