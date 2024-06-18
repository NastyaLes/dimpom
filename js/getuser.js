if (localStorage.getItem("code")) {
  async function getUSer() {
    var params = new URLSearchParams();
    params.set("code", localStorage.getItem("code"));
    const response = await fetch("../php/getuser.php", {
      method: "POST",
      body: params,
    });
    const result = await response.json();
    return result;
  }
  getUSer().then((textResponse) => {
    document.getElementById("name-order").value = textResponse[0]["name"];
    document.getElementById("tel-order").value = textResponse[0]["tel"];
  });
}
