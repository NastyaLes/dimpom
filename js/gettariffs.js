async function getTariffs() {
  const response = await fetch("../php/gettariffs.php");
  const result = await response.json();
  return result;
}
getTariffs().then((textResponse) => {
  let text = `<li class='tariffs'><a href='#' class='link active'>${textResponse[0]["name"]}</a></li>`;
  let text2 = `<div id="page-${textResponse[0]["name"]}" class="page"><h4>Краткое описание тарифа ${textResponse[0]["name"]}:</h4><ul class="info"><li>Минимальная цена: ${textResponse[0]["min_price"]} рублей</li><li>Цена за километр: ${textResponse[0]["km_price"]} рублей</li><li>Бесплатное ожидание: 5 минут</li><li>Платное ожидание: 10 минут</li></ul></div>`;
  let text3 = `<li>Минимальная цена: ${textResponse[0]["min_price"]} рублей</li><li>Цена за километр: ${textResponse[0]["km_price"]} рублей</li><li>Бесплатное ожидание: 5 минут</li><li>Платное ожидание: 10 минут</li>`;
  for (var i = 1; i < Object.keys(textResponse).length; i++) {
    text += `<li class='tariffs'><a href='#' class='link'>${textResponse[i]["name"]}</a></li>`;
    text2 += `<div id="page-${textResponse[i]["name"]}" class="page hidden"><h4>Тариф: ${textResponse[i]["name"]}</h4><ul class="info"><li>Минимальная цена: ${textResponse[i]["min_price"]} рублей</li><li>Цена за километр: ${textResponse[i]["km_price"]} рублей</li><li>Бесплатное ожидание: 5 минут</li><li>Платное ожидание: 10 минут</li></ul></div>`;
  }
  document.getElementById("links-nav").innerHTML = text;
  document.getElementById("pages-nav").innerHTML = text2;
});

function zappp() {
  var links = document.querySelectorAll(".link"); //применяется для выбора всех HTML-элементов, подходящих под указанный css-селектор
  links.forEach(function (link) {
    link.addEventListener("click", function (event) {
      //для каждой ссылки устанавливаем событие клика
      event.preventDefault(); //убираем перезагрузку страницы при клике
      var page = this.textContent; //берем контент ссылки
      var galleryPages = document.querySelectorAll(".page");
      galleryPages.forEach(function (page) {
        page.classList.add("hidden"); //добавляем класс к элементу
      });
      document.getElementById("page-" + page).classList.remove("hidden"); //удаляем класс у элемента
      links.forEach(function (link) {
        link.classList.remove("active");
      });
      this.classList.add("active");
    });
  });
}
setTimeout(zappp, 400);
