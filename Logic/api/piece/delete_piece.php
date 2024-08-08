<?php
include "../../connect.php";

if (isset($_POST['piece_id']) && !empty($_POST['piece_id'])) {
    $piece_id = $_POST['piece_id'];

    $stmt = $connexion->prepare("DELETE FROM piece WHERE code = ?");
    $stmt->bind_param("i", $piece_id);
    if ($stmt->execute()) {
        echo "Piece deleted successfully.";
    } else {
        echo "Error deleting piece: " . $connexion->error;
    }
} else {
    echo "Invalid piece ID.";
}

$connexion->close();
?>
