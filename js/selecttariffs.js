async function getTariffs() {
  const response = await fetch("../php/gettariffs.php");
  const result = await response.json();
  return result;
}
getTariffs().then((textResponse) => {
  let text = "";
  for (var i = 0; i < Object.keys(textResponse).length; i++) {
    text += `<option value="${textResponse[i]["km_price"]}">${textResponse[i]["name"]} (от ${textResponse[i]["min_price"]} рублей)</option>`;
  }
  document.getElementById("tariff-order").innerHTML = text;
});
