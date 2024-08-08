<?php
include "../../connect.php";

$code = $_POST['code'];
$ref = $_POST['ref'];
$qte = $_POST['qte'];

$stmt = $connexion->prepare("INSERT INTO Piece(code,ref,qte) VALUES (?,?,?)");
$stmt->bind_param("isi", $code, $ref, $qte);
if ($stmt->execute()) {
    echo "Piece Added successfully.";
} else {
    echo "Error adding piece: " . $connexion->error;
}

$connexion->close();
