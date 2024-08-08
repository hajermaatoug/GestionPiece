<?php
include "../../connect.php";

$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = $connexion->real_escape_string($query);

$requete = "SELECT code, ref, qte FROM piece WHERE code LIKE '%$query%' OR ref LIKE '%$query%'";
$resultat = $connexion->query($requete);

if ($resultat->num_rows > 0) {
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<th>Code</th>";
        echo "<th>Referance</th>";
        echo "<th>Quantité</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style='width: 15%'>" . $row['code'] . "</td>";
        echo "<td style='width: 45%'>" . $row['ref'] . "</td>";
        echo "<td style='width: 15%'>" . $row['qte'] . "</td>";
        echo "<td style='width: 10%'>
                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modification" . $row['code'] . "'>Modifier</button>
                <div class='modal fade' id='modification" . $row['code'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Modification</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body' style='margin: 20px;'>
                                <form>
                                    <div>
                                        <label class='form-label'>Code :</label>
                                        <input class='form-control' type='text' id='code" . $row['code'] . "' value='" . $row['code'] . "' disabled>
                                    </div>
                                    <div>
                                        <label class='form-label'>Referance :</label>
                                        <input class='form-control' type='text' id='ref" . $row['code'] . "' value='" . $row['ref'] . "'>
                                    </div>
                                    <div>
                                        <label class='form-label'>Quantité :</label>
                                        <input class='form-control' type='text' id='qte" . $row['code'] . "' value='" . $row['qte'] . "'>
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                <button type='button' class='btn btn-primary' onclick='modifierPiece(" . $row['code'] . ")'>Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>";
        echo "<td style='width: 10%'>
                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#supression" . $row['code'] . "'>Supprimer</button>
                <div class='modal fade' id='supression" . $row['code'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Suppression</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                Voulez-vous supprimer " . $row['ref'] . "
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                <button type='button' class='btn btn-primary' onclick='deletePiece(" . $row['code'] . ")'>Oui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Aucune donnée trouvée.</td></tr>";
}
$connexion = null;
?>
