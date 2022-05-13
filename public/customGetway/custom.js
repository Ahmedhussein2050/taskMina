//pass your public key from tap's dashboard
var tap = Tapjsli('pk_test_cDaAhsNHqV0MZbO3R54SezFC');

var elements = tap.elements({});
var style = {
    base: {
        color: '#535353',
        lineHeight: '18px',
        fontFamily: 'sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: 'rgba(0, 0, 0, 0.26)',
            fontSize: '15px'
        }
    },
    invalid: {
        color: 'red'
    }
};
// input labels/placeholders
var labels = {
    cardNumber: "Card Number",
    expirationDate: "MM/YY",
    cvv: "CVV",
    cardHolder: "Card Holder Name"
};
//payment options
var paymentOptions = {
    currencyCode: ["SAR"],
    labels: labels,
    TextDirection: 'ltr'
}
//create element, pass style and payment options
var card = elements.create('card', { style: style }, paymentOptions);
//mount element
card.mount('#element-container');
console.log(card.mount('#element-container'));
console.log(card);
//card change event listener
card.addEventListener('change', function (event) {
    if (event.BIN) {
        console.log(event.BIN)
    }
    if (event.loaded) {
        console.log("UI loaded :" + event.loaded);
        console.log("current currency is :" + card.getCurrency())
    }
    var displayError = document.getElementById('error-handler');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission
var form = document.getElementById('form-container');
form.addEventListener('submit', function (event) {
    event.preventDefault();

    tap.createToken(card).then(function (result) {
        console.log(result);
        if (result.error) {
            console.log('qqqq');
            // Inform the user if there was an error
            var errorElement = document.getElementById('error-handler');
            errorElement.textContent = result.error.message;
        } else {
            console.log('aaa');

            // Send the token to your server
            var errorElement = document.getElementById('success');
            errorElement.style.display = "block";
            var tokenElement = document.getElementById('token');
            tokenElement.textContent = result.id;

            tapTokenHandler(result)

        }
    });
});
function tapTokenHandler(result) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('form-container');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'tapToken');
    hiddenInput.setAttribute('value', result.id);
    console.log(hiddenInput)
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}

