function order(e){
    e.preventDefault();
    var form = document.getElementById('form-order');
    var params = new FormData(form); 
    fetch('../php/order.php', {
        method: 'POST',
        body: params})
    .then(
        response => {
            return response.text();
        }
    )
    .then(
        textResponse => {
            document.getElementById('answer-order').innerHTML = textResponse;
      }
   );
}