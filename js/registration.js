function registration(e) {
  e.preventDefault();
  var form = document.getElementById("form-registration");
  var params = new FormData(form);
  fetch("../php/registration.php", {
    method: "POST",
    body: params,
  })
    .then((response) => {
      return response.text();
    })
    .then((textResponse) => {
      document.getElementById("answer-registration").innerHTML = textResponse;
    });
}
