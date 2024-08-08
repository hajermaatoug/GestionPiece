<tr>
    <th>ID</th>
    <th>Code Pièce</th>
    <th>Quantité</th>
    <th>Date</th>
    <th></th>
    <th></th>
</tr>
<?php
include "../../connect.php";

$query = $_GET['query'];
$requete = $connexion->prepare("SELECT id, code_piece, qte, date FROM commande WHERE code_piece LIKE ? OR date LIKE ?");
$likeQuery = "%" . $query . "%";
$requete->bind_param("ss", $likeQuery, $likeQuery);
$requete->execute();
$resultat = $requete->get_result();

if ($resultat->num_rows > 0) {
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='width: 10%'>" . $row['id'] . "</td>";
        echo "<td style='width: 30%'>" . $row['code_piece'] . "</td>";
        echo "<td style='width: 20%'>" . $row['qte'] . "</td>";
        echo "<td style='width: 20%'>" . $row['date'] . "</td>";
        echo "<td style='width: 10%'>
                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modificationCommand" . $row['id'] . "'>Modifier</button>
                <div class='modal fade' id='modificationCommand" . $row['id'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Modification</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body' style='margin: 20px;'>
                                <form>
                                    <div>
                                        <label class='form-label'>ID :</label>
                                        <input class='form-control' type='text' id='command-id" . $row['id'] . "' value='" . $row['id'] . "' disabled>
                                    </div>
                                    <div>
                                        <label class='form-label'>Code Pièce :</label>
                                        <input class='form-control' type='text' id='command-code_piece" . $row['id'] . "' value='" . $row['code_piece'] . "'>
                                    </div>
                                    <div>
                                        <label class='form-label'>Quantité :</label>
                                        <input class='form-control' type='text' id='command-qte" . $row['id'] . "' value='" . $row['qte'] . "'>
                                    </div>
                                    <div>
                                        <label class='form-label'>Date :</label>
                                        <input class='form-control' type='date' id='command-date" . $row['id'] . "' value='" . $row['date'] . "'>
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                <button type='button' class='btn btn-primary' onclick='modifierCommand(" . $row['id'] . ")'>Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>";
        echo "<td style='width: 10%'>
                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#supressionCommand" . $row['id'] . "'>Supprimer</button>
                <div class='modal fade' id='supressionCommand" . $row['id'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Suppression</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                Voulez-vous supprimer la commande de " . $row['code_piece'] . "
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                <button type='button' class='btn btn-primary' onclick='deleteCommand(" . $row['id'] . ")'>Oui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Aucune commande trouvée.</td></tr>";
}

$connexion = null;
?>