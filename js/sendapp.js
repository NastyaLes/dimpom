function sendapp(e) {
  e.preventDefault();
  var form = document.getElementById("form-app");
  var params = new FormData(form);
  fetch("../php/sendapp.php", {
    method: "POST",
    body: params,
  })
    .then((response) => {
      return response.text();
    })
    .then((responseText) => {
      document.getElementById("answer-app").innerHTML = responseText;
    });
}
