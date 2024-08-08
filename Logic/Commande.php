<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Pieces et Commandes</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="page">
        <nav>
            <?php
            include "./include/ConnectedSidebar.php";
            Sidebar("commande");
            ?>
        </nav>
        <main>

            <div class='modal fade' id='ajouterPiece' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Nouvelle Pièce</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' style="margin: 20px;">
                            <form>
                                <div>
                                    <label class="form-label">Code :</label>
                                    <input class="form-control" type="text" id="new-code">
                                </div>
                                <div>
                                    <label class="form-label">Référence :</label>
                                    <input class="form-control" type="text" id="new-ref">
                                </div>
                                <div>
                                    <label class="form-label">Quantité :</label>
                                    <input class="form-control" type="text" id="new-qte">
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

            <h1 class="title mt-5">Gestion des Commandes</h1>
            <div class="mb-3 d-flex">
                <input class="form-control" type="text" id="search-command" placeholder="Rechercher une commande">
                <button type="button" class="btn btn-primary" onclick="searchCommands()">Chercher</button>
            </div>
            <table id="commands-table" class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Code Pièce</th>
                    <th>Quantité</th>
                    <th>Date</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                include "connect.php";
                $requete = "SELECT id, code_piece, qte, date FROM commande";
                $resultat = $connexion->query($requete);
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
                                                            <select class='form-control' id='command-code_piece" . $row['id'] . "'>";
                        $piece_result = $connexion->query("SELECT code FROM piece");
                        if ($piece_result->num_rows > 0) {
                            while ($piece_row = $piece_result->fetch_assoc()) {
                                $selected = $piece_row['code'] == $row['code_piece'] ? "selected" : "";
                                echo "<option value='" . $piece_row['code'] . "' " . $selected . ">" . $piece_row['code'] . "</option>";
                            }
                        }
                        echo "</select>
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
                    echo "<tr><td colspan='6'>Aucune donnée trouvée dans la table 'commande'.</td></tr>";
                }
                ?>
            </table>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target="#ajouterCommand">Ajouter une Commande</button>

            <div class='modal fade' id='ajouterCommand' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Nouvelle Commande</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' style="margin: 20px;">
                            <form>
                                <div>
                                    <label class="form-label">Code Pièce :</label>
                                    <select class="form-control" id="new-command-code_piece">
                                        <?php
                                        include "./connect.php";
                                        $piece_result = $connexion->query("SELECT code FROM piece");
                                        if ($piece_result->num_rows > 0) {
                                            while ($piece_row = $piece_result->fetch_assoc()) {
                                                echo "<option value='" . $piece_row['code'] . "'>" . $piece_row['code'] . "</option>";
                                            }
                                        }
                                        $connexion = null;
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Quantité :</label>
                                    <input class="form-control" type="text" id="new-command-qte">
                                </div>
                                <div>
                                    <label class="form-label">Date :</label>
                                    <input class="form-control" type="date" id="new-command-date">
                                </div>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                            <button type='button' class='btn btn-primary' onclick="ajouterCommand()">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        // Existing functions for pieces management...

        // New functions for commands management
        function searchCommands() {
            let query = document.getElementById("search-command").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("commands-table").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "./api/commande/search_commands.php?query=" + query, true);
            xhttp.send();
        }

        function ajouterCommand() {
            let code_piece = document.getElementById("new-command-code_piece").value;
            let qte = document.getElementById("new-command-qte").value;
            let date = document.getElementById("new-command-date").value;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "./api/commande/ajouter_command.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("code_piece=" + code_piece + "&qte=" + qte + "&date=" + date);
        }

        function modifierCommand(id) {
            let code_piece = document.getElementById("command-code_piece" + id).value;
            let qte = document.getElementById("command-qte" + id).value;
            let date = document.getElementById("command-date" + id).value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload(); // Reload the page after successful modification
                }
            };
            xhttp.open("POST", "./api/commande/modifier_command.php", true); // Specify the correct PHP script
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("id=" + id + "&code_piece=" + code_piece + "&qte=" + qte + "&date=" + date);
        }

        function deleteCommand(commandId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "./api/commande/delete_command.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("command_id=" + commandId);
        }
    </script>
</body>

</html>
