<?php
include "../../connect.php";

$code_piece = $_POST['code_piece'];
$qte = $_POST['qte'];
$date = $_POST['date'];

// Start a transaction
$connexion->begin_transaction();

try {
    // Insert the new command
    $requete = $connexion->prepare("INSERT INTO commande (code_piece, qte, date) VALUES (?, ?, ?)");
    $requete->bind_param("sis", $code_piece, $qte, $date);

    if (!$requete->execute()) {
        throw new Exception("Erreur lors de l'ajout de la commande: " . $requete->error);
    }

    // Decrement the quantity of the piece
    $requete2 = $connexion->prepare("UPDATE piece SET qte = qte - ? WHERE code = ?");
    $requete2->bind_param("is", $qte, $code_piece);

    if (!$requete2->execute()) {
        throw new Exception("Erreur lors de la mise à jour de la pièce: " . $requete2->error);
    }

    // Commit the transaction
    $connexion->commit();

    echo "Commande ajoutée et quantité de pièce mise à jour avec succès";
} catch (Exception $e) {
    // Rollback the transaction on error
    $connexion->rollback();
    echo $e->getMessage();
}

$connexion = null;
