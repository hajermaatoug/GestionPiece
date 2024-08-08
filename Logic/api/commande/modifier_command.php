<?php
include "../../connect.php";

$id = $_POST['id'];
$code_piece = $_POST['code_piece'];
$qte = $_POST['qte'];
$date = $_POST['date'];

$requete = $connexion->prepare("UPDATE commande SET code_piece = ?, qte = ?, date = ? WHERE id = ?");
$requete->bind_param("sisi", $code_piece, $qte, $date, $id);

if ($requete->execute()) {
    echo "Commande modifiée avec succès";
} else {
    echo "Erreur : " . $requete->error;
}

$connexion = null;
?>
