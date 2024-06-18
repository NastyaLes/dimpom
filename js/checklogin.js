function checklogin(e) {
  e.preventDefault();
  var form = document.getElementById("form-login");
  var params = new FormData(form);
  fetch("../php/login.php", {
    method: "POST",
    body: params,
  })
    .then((response) => {
      return response.text();
    })
    .then((responseText) => {
      if (responseText == "Неправильный логин или пароль") {
        document.getElementById("answer-login").innerHTML = responseText;
      } else {
        localStorage.setItem("code", responseText);
        document.location.replace(
          "http://dp-leskina.сделай.site/html/account.html"
        );
      }
    });
}
