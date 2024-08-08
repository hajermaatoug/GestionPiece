<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: ../Auth/Login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Pieces</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="page">
        <nav>
            <?php
            include "./include/ConnectedSidebar.php";
            Sidebar("piece");
            ?>
        </nav>
        <main>
            <div class="justify-content-center align-items-center mt-10 mx-5 -container">
                <h1 class="title">Gestion Piece</h1>
                <div class="mb-3 d-flex">
                    <input class="form-control" type="text" id="search" placeholder="Rechercher une pièce">
                    <button type="button" class="btn btn-primary" onclick="searchPieces()">Chercher</button>
                </div>

                <table id="pieces-table" class="table table-striped">
                    <tr>
                        <th>Code</th>
                        <th>Referance</th>
                        <th>Quantité</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    include "connect.php";

                    $requete = "SELECT code, ref, qte FROM piece";
                    $resultat = $connexion->query($requete);
                    if ($resultat->num_rows > 0) {
                        while ($row = $resultat->fetch_assoc()) {
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
                        echo "<tr><td colspan='5'>Aucune donnée trouvée dans la table 'piece'.</td></tr>";
                    }
                    $connexion = null;
                    ?>
                </table>

                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target="#ajouter">Ajouter une Piece</button>

                <div class='modal fade' id='ajouter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Nouvelle Piece</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body' style="margin: 20px;">
                                <form>
                                    <div>
                                        <label class="form-label">Code :</label>
                                        <input class="form-control" type="text" id="code">
                                    </div>
                                    <div>

                                        <label class="form-label">Referance : </label>
                                        <input class="form-control" type="text" id="ref">
                                    </div>

                                    <div>
                                        <label class="form-label">Quantité : </label>
                                        <input class="form-control" type="text" id="qte">
                                    </div>


                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                <button type='button' class='btn btn-primary' onclick="ajouterPiece()">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>

        </main>
        <aside>

        </aside>
    </div>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        function ajouterPiece() {
            let code = document.getElementById("code").value;
            let ref = document.getElementById("ref").value;
            let qte = document.getElementById("qte").value;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "./api/piece/ajouter_piece.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("code=" + code + "&ref=" + ref + "&qte=" + qte);
        }

        function modifierPiece(id) {
            let code = document.getElementById("code" + id).value;
            let ref = document.getElementById("ref" + code).value;
            let qte = document.getElementById("qte" + code).value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload(); // Reload the page after successful modification
                }
            };
            xhttp.open("POST", "./api/piece/modifier_piece.php", true); // Specify the correct PHP script
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("code=" + code + "&ref=" + ref + "&qte=" + qte);
        }


        function deletePiece(pieceId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "./api/piece/delete_piece.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("piece_id=" + pieceId);

        }

        function searchPieces() {
            let query = document.getElementById("search").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("pieces-table").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "./api/piece/search_piece.php?query=" + encodeURIComponent(query), true);
            xhttp.send();
        }
    </script>
</body>
</html>