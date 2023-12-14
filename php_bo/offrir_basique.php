<?php 
include 'db_connect.php';
include 'bo_check.php';

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $typeAbonnement = 'basique';
    $dateDebut = date("Y-m-d");
    $dateFin = date("Y-m-d", strtotime("+1 month"));

    try {
        // Préparation de la requête avec la clause ON DUPLICATE KEY UPDATE
        $stmt = $pdo->prepare("INSERT INTO abonnements (user_id, type_abonnement, est_paye, date_debut, date_fin) 
                               VALUES (:user_id, :type_abonnement, 1, :date_debut, :date_fin) 
                               ON DUPLICATE KEY UPDATE 
                               type_abonnement = :type_abonnement_update, 
                               est_paye = 1, 
                               date_debut = :date_debut_update, 
                               date_fin = :date_fin_update");

        // Exécution de la requête avec les paramètres appropriés
        $stmt->execute([
            ':user_id' => $userId,
            ':type_abonnement' => $typeAbonnement,
            ':type_abonnement_update' => $typeAbonnement,
            ':date_debut' => $dateDebut,
            ':date_debut_update' => $dateDebut,
            ':date_fin' => $dateFin,
            ':date_fin_update' => $dateFin
        ]);
        echo "Abonnement basique offert avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

