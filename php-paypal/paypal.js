paypal.Buttons({
    createOrder: function (data, actions) {
        // Configurez la transaction avec les détails de votre produit ou service
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '0' 
                }
            }]
        });
    },
    onApprove: function (data, actions) {
        // Capturez le paiement lorsque l'utilisateur approuve la transaction
        return actions.order.capture().then(function (details) {
            // Insérez ici le code à exécuter après le paiement réussi, on peut supprimer l'alert
            alert('Paiement réussi !');
        });
    }
}).render('#paypal-button-container');
