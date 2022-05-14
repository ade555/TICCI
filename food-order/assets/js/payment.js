console.log("Hello world");

function pay_now() {
    var options = {
        "key": "rzp_test_m8D9kQpB5lY3So", // Enter the Key ID generated from the Dashboard
        "amount": "50000", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "Flavours of the North",
        "description": "Test Transaction",
        "image": "/assets/css/img/about1.jpg",
        "handler": function (response){
          console.log(response);
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
    
}