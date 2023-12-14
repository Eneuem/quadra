<?php 
require_once('../vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51ONDw8C1fQp5mFZfNo92rN47eJkdPMbhoj0xxj9H5veHHiPA3yisajnabYHfMEPWSBZcvnnK7nASXL70lhDy8Jyg00vS0Uxa1j'); // Utilisez votre nouvelle clé secrète Stripe

header('Content-Type: application/json');

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Log de l'erreur
    http_response_code(400);
    exit();
}

// Gérer l'événement de paiement réussi
if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;


    $userId = $session->client_reference_id;
    $abonnementType = 'premium'; 
    $dateDebut = date("Y-m-d"); 
    $dateFin = date("Y-m-d", strtotime("+1 month")); 

    require '../php/db_connect.php';

    try {
        $stmt = $pdo->prepare("INSERT INTO abonnements (user_id, type_abonnement, est_paye, date_debut, date_fin) VALUES (:user_id, :type_abonnement, :est_paye, :date_debut, :date_fin) ON DUPLICATE KEY UPDATE type_abonnement=:type_abonnement, est_paye=:est_paye, date_debut=:date_debut, date_fin=:date_fin");
        
        $stmt->execute([
            ':user_id' => $userId,
            ':type_abonnement' => $abonnementType,
            ':est_paye' => $estPaye,
            ':date_debut' => $dateDebut,
            ':date_fin' => $dateFin
        ]);

        // Logique après mise à jour réussie
        echo "Abonnement mis à jour avec succès.";
    } catch (PDOException $e) {
        // Gérer l'erreur ici
        echo "Erreur lors de la mise à jour de l'abonnement : " . $e->getMessage();
    }
}


http_response_code(200);
?>