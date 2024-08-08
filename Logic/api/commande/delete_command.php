<?php
include "../../connect.php";

$id = $_POST['command_id'];

// Start a transaction
$connexion->begin_transaction();

try {
    // Fetch the command details before deleting
    $requete_fetch = $connexion->prepare("SELECT code_piece, qte FROM commande WHERE id = ?");
    $requete_fetch->bind_param("i", $id);
    $requete_fetch->execute();
    $result = $requete_fetch->get_result();

    if ($result->num_rows == 0) {
        throw new Exception("Commande introuvable");
    }

    $command = $result->fetch_assoc();
    $code_piece = $command['code_piece'];
    $qte = $command['qte'];

    // Delete the command
    $requete_delete = $connexion->prepare("DELETE FROM commande WHERE id = ?");
    $requete_delete->bind_param("i", $id);

    if (!$requete_delete->execute()) {
        throw new Exception("Erreur lors de la suppression de la commande: " . $requete_delete->error);
    }

    // Increment the quantity of the piece
    $requete_update = $connexion->prepare("UPDATE piece SET qte = qte + ? WHERE code = ?");
    $requete_update->bind_param("is", $qte, $code_piece);

    if (!$requete_update->execute()) {
        throw new Exception("Erreur lors de la mise à jour de la pièce: " . $requete_update->error);
    }

    // Commit the transaction
    $connexion->commit();

    echo "Commande supprimée et quantité de pièce mise à jour avec succès";
} catch (Exception $e) {
    // Rollback the transaction on error
    $connexion->rollback();
    echo $e->getMessage();
}

$connexion = null;
?>
