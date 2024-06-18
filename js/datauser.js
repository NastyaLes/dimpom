document.addEventListener("DOMContentLoaded", function () {
  let text = "";
  //если в localStorage есть код пользователя, выводим на страницу его данные и все заказы
  if (localStorage.getItem("code")) {
    async function getOrders() {
      let params = new URLSearchParams();
      params.set("code", localStorage.getItem("code"));
      const response = await fetch("../php/getorders.php", {
        method: "POST",
        body: params,
      });
      const result = await response.json();
      return result;
    }
    getOrders().then((textResponse) => {
      if (Object.keys(textResponse).length == 0) {
        document.getElementById("table").innerHTML = "<p>У вас нет заказов</p>";
      } else {
        for (let i = 0; i < Object.keys(textResponse).length; i++) {
          text += `<tr><td>${textResponse[i]["name"]} ${textResponse[i]["surname"]}</td><td>${textResponse[i]["count_min"]}</td><td>${textResponse[i]["price"]}</td><td>${textResponse[i]["comm"]}</td><td>${textResponse[i]["status"]}</td><td>${textResponse[i]["date_create"]}</td><td><button class="btn-delete" onclick="deleteorder('${textResponse[i]["status"]}', ${textResponse[i]["id"]});">Отменить заказ</button></td></tr>`;
        }
        document.querySelector("tbody").innerHTML = text;
      }
    });
    async function getUSer() {
      let params = new URLSearchParams();
      params.set("code", localStorage.getItem("code"));
      const response = await fetch("../php/getuser.php", {
        method: "POST",
        body: params,
      });
      const result = await response.json();
      return result;
    }
    getUSer().then((textResponse) => {
      document.getElementById(
        "data-user"
      ).innerHTML = `<p>Ваше имя: ${textResponse[0]["name"]}</p><p>Ваш номер телефона: ${textResponse[0]["tel"]}</p>`;
    });
  }
  //если нет, делаем страницу недоступной
  else {
    document.querySelector("main").innerHTML =
      "<p>У вас нет доступа к данной странице</p>";
  }
});
function deleteorder(status, id) {
  async function getOrders() {
    let params = new URLSearchParams();
    params.set("status", status);
    params.set("id", id);
    const response = await fetch("../php/deleteorder.php", {
      method: "POST",
      body: params,
    });
    const result = await response.text();
    return result;
  }
  getOrders().then((textResponse) => {
    alert(textResponse);
    location.reload();
  });
}
function deleteaccount(e) {
  e.preventDefault();
  async function deleteAcc() {
    let params = new URLSearchParams();
    params.set("code", localStorage.getItem("code"));
    const response = await fetch("../php/deleteaccount.php", {
      method: "POST",
      body: params,
    });
    const result = await response.text();
    return result;
  }
  deleteAcc().then((textResponse) => {
    localStorage.removeItem("code");
    alert(textResponse);
    document.location.replace("http://pr-leskina.сделай.site/html/login.html");
  });
}
