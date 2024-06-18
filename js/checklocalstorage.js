document.addEventListener("DOMContentLoaded", function () {
  let text1 = "";
  let text2 = "";
  if (localStorage.getItem("code")) {
    text1 = `<button class="btn-header" onclick="localStorage.removeItem('code'); document.location='login.html';">Выйти</button>`;
    text2 = `<button class="btn-header" onclick="localStorage.removeItem('code'); document.location='html/login.html';">Выйти</button>`;
    let ul = document.getElementById("navigation");
    let li = document.createElement("li");
    if (document.getElementById("buttons-header")) {
      li.innerHTML = '<a href="account.html">Мой аккаунт</a>';
      ul.appendChild(li);
    } else {
      li.innerHTML = '<li><a href="html/account.html">Мой аккаунт</a></li>';
      ul.appendChild(li);
    }
  } else {
    text1 = `<button class="btn-header" onclick="document.location='login.html'">Логин</button>
        <button class="btn-header" onclick="document.location='registration.html'">Регистрация</button>`;
    text2 = `<button class="btn-header" onclick="document.location='html/login.html'">Логин</button>
        <button class="btn-header" onclick="document.location='html/registration.html'">Регистрация</button>`;
  }
  if (document.getElementById("buttons-header")) {
    document.getElementById("buttons-header").innerHTML = text1;
  } else {
    document.getElementById("buttons-index").innerHTML = text2;
  }
});
