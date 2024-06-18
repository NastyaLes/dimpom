initMap();
let coors_in = '';
let coors_to = '';
const getAddress1 = (address) => {
  let length = address.length;

  if (length < 4) {
      alert('Слишком маленький запрос');
  }

  else {
      var params = new URLSearchParams();
      params.set('address', address);

      async function fetchGetAddress1() {
        const response = await fetch('../php/geosajest.php', {method: 'POST', body: params});
        const result = await response.text();
        return result;
      }

      fetchGetAddress1().then(textResponse => {
        document.getElementById("in-order").value = textResponse;
        var params = new URLSearchParams();
        params.set('coors', textResponse);

        async function fetchGeocoder1() {
          const response = await fetch('../php/geocoder2.php', {method: 'POST', body: params});
          const result = await response.text();
          return result;
        }
        
        fetchGeocoder1().then(textResponse => {
          coors_in = textResponse;
          distance();
});
});
};
};

const getAddress2 = (address) => {
let length = address.length;

if (length < 4) {
  alert('Слишком маленький запрос');
}

else {
var params = new URLSearchParams();
params.set('address', address);

async function fetchGetAddress2() {
const response = await fetch('php/geosajest.php', {method: 'POST', body: params});
const result = await response.text();
return result;
}

fetchGetAddress2().then(textResponse => {
document.getElementById("to-order").value = textResponse;
var params = new URLSearchParams();
params.set('coors', textResponse);

async function fetchGeocoder2() {
const response = await fetch('../php/geocoder2.php', {method: 'POST', body: params});
const result = await response.text();
return result;
}

fetchGeocoder2().then(textResponse => {
  coors_to = textResponse;
  distance();
});

});
};
};

async function initMap() {

  //Промис `ymaps3.ready` будет зарезолвлен, когда загрузятся все компоненты основного модуля API
  await ymaps3.ready;
  ymaps3.strictMode = true;

  const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer} = ymaps3;
  const {YMapDefaultMarker} = await ymaps3.import('@yandex/ymaps3-markers@0.0.1'); //Пакет JS API, предоставляющий дополнительную функциональность маркеров

  //Иницилиазируем карту
  const map = new YMap( //Передаём ссылку на HTMLElement контейнера
  document.getElementById('map'),
  //Передаём параметры инициализации карты
  {
    location: {
      center: [30.3157413,  59.9391449], //Координаты центра карты
      zoom: 14, //Уровень масштабирования
    }
  });
  
  map.addChild(new YMapDefaultSchemeLayer()); //Добавим слой с дорогами и зданиями
  map.addChild(new YMapDefaultFeaturesLayer()); // Добавим слой для маркеров

  //Событие срабатывает, когда пользователь отпускает первый маркер
  const onDragEndHandler1 = () => {
    map.addChild(marker2);
    var params = new URLSearchParams();
    coors_in = String(marker1.coordinates);
    params.set('coors', String(marker1.coordinates));

    async function fetchGeocoder3() {
      const response = await fetch('../php/geocoder.php', {method: 'POST', body: params});
      const result = await response.text();
      return result;
    }

    fetchGeocoder3().then(textResponse => {
      document.getElementById("in-order").value = textResponse;
      distance();
    });
  };

  //Событие срабатывает, когда пользователь отпускает второй маркер
  const onDragEndHandler2 = () => {
    var params = new URLSearchParams();
    coors_to = String(marker2.coordinates);
    params.set('coors', String(marker2.coordinates));

    async function fetchGeocoder4() {
      const response = await fetch('../php/geocoder.php', {method: 'POST', body: params});
      const result = await response.text();
      return result;
    }

    fetchGeocoder4().then(textResponse => {
      document.getElementById("to-order").value = textResponse;
      distance();
    });
  };

  const content = document.createElement('section');
  // Инициализируем маркер
  const marker1 = new YMapDefaultMarker(
    {
      coordinates: [30.3157413,  59.9391449],
      draggable: true,
      title: "Ваше местоположение",
      subtitle: "Переместите метку",
      color: "orange",
      onDragEnd: onDragEndHandler1
    },
    content
  );
  // Добавим маркер на карту
  map.addChild(marker1);

  const marker2 = new YMapDefaultMarker(
    {
      coordinates: [30.3157413,  59.9391449],
      draggable: true,
      title: "Место назначения",
      subtitle: "Переместите метку",
      color: "orange",
      onDragEnd: onDragEndHandler2
    },
    content
  );
}

async function distance() {
if (document.getElementById('in-order').value.length > 0 && document.getElementById('to-order').value.length > 0) {
  
  async function fetchDistanceMatrix() {
    var params = new URLSearchParams();
    params.set('coors_in', coors_in);
    params.set('coors_to', coors_to);
    const response = await fetch('../php/distancematrix.php', {method: 'POST', body: params});
    const result = await response.json();
    return result;
    }

    fetchDistanceMatrix().then(textResponse => {
    let km = Math.round(textResponse['routes'][0]['distance'] / 1000);
    document.getElementById("time-order").value = Math.round(textResponse['routes'][0]['duration'] / 60);
    document.getElementById("km-order").value = km;
    let select = document.getElementById('tariff-order').value; //цена за каждый км
    let price = km * Number(select);
    let select_index = document.getElementById('tariff-order').selectedIndex;

    async function getTariffs() {
      const response = await fetch('../php/gettariffs.php');
      const result = await response.json();
      return result;
    }
    getTariffs().then(textResponse => {
      price = price + Number(textResponse[select_index]['min_price']);
      document.getElementById("price-order").value = price.toFixed(2);
    });
});
};
}