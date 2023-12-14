<?php // create_stripe_session.php
require_once('../vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51ONDw8C1fQp5mFZfNo92rN47eJkdPMbhoj0xxj9H5veHHiPA3yisajnabYHfMEPWSBZcvnnK7nASXL70lhDy8Jyg00vS0Uxa1j');

header('Content-Type: application/json');

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Abonnement Premium',
                ],
                'unit_amount' => 2000, // 20.00 EUR
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://votre_site_web/success.html',
        'cancel_url' => 'https://votre_site_web/cancel.html',
    ]);

    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>