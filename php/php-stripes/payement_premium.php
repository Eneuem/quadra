<script src="https://js.stripe.com/v3/"></script>

<button id="checkout-button" class="bg-red-600 text-white px-4 py-2 rounded-xl mt-auto animate-pulse">Payer maintenant</button>

<script>
    var stripe = Stripe('pk_test_51ONDw8C1fQp5mFZfKUAuNBjrGoFkYh7mJ8halFujXNihDeERFQFT3xmOAJnHlKgXwRypD54Lkau58ORbgOvnoADA00xonoKJG0');

    var checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', function (event) {
        event.preventDefault();

        fetch('php/php-stripes/create_stripe_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(session) {
            if (session.id) {
                // Utiliser stripe.redirectToCheckout pour gérer la redirection
                return stripe.redirectToCheckout({ sessionId: session.id });
            } else {
                throw new Error('Session ID not received');
            }
        })
        .then(function(result) {
            // Gérer le résultat de redirectToCheckout
            if (result.error) {
                alert(result.error.message);
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
    });
</script>

