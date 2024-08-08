<?php
include "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code']) && isset($_POST['ref']) && isset($_POST['qte'])) {
    $code = $_POST['code'];
    $ref = $_POST['ref'];
    $qte = $_POST['qte'];

    echo $code ."\n";
    echo $ref ."\n";
    echo $qte ."\n";

    // Prepare and execute the update statement
    $stmt = $connexion->prepare("UPDATE Piece SET ref=?, qte=? WHERE code=?");
    $stmt->bind_param("sii", $ref, $qte, $code);
    if ($stmt->execute()) {
        echo "Piece updated successfully.";
    } else {
        echo "Error updating piece: " . $connexion->error;
    }
} else {
    echo "Invalid request.";
}

$connexion->close();
?>
