<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51ONDw8C1fQp5mFZfNo92rN47eJkdPMbhoj0xxj9H5veHHiPA3yisajnabYHfMEPWSBZcvnnK7nASXL70lhDy8Jyg00vS0Uxa1j');

$endpoint_secret = 'whsec_90cd09a1d0d11774d050b35a7b84ca67b611b3c0c65c88d7caaecfb3d03e5cad'; // Remplacez avec votre secret de webhook

header('Content-Type: application/json');

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;
    $userId = $session->client_reference_id;
    $abonnementType = 'premium';
    $dateDebut = date("Y-m-d");
    $dateFin = date("Y-m-d", strtotime("+1 month"));
    $estPaye = 1;

    require 'db_connect.php';

    try {
        $stmt = $pdo->prepare("INSERT INTO abonnements (user_id, type_abonnement, est_paye, date_debut, date_fin) VALUES (:user_id, :type_abonnement, :est_paye, :date_debut, :date_fin) ON DUPLICATE KEY UPDATE type_abonnement=:type_abonnement, est_paye=:est_paye, date_debut=:date_debut, date_fin=:date_fin");
        
        $stmt->execute([
            ':user_id' => $userId,
            ':type_abonnement' => $abonnementType,
            ':est_paye' => $estPaye,
            ':date_debut' => $dateDebut,
            ':date_fin' => $dateFin
        ]);

        echo "Abonnement mis à jour avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de l'abonnement : " . $e->getMessage();
    }
}

http_response_code(200);
?>
