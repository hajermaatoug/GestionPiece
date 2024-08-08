<?php
session_start();
if (isset($_SESSION['logged'])) {
    header("Location: ../Logic/Piece.php");
}
include "connect.php";
$error = "";
if (isset($_POST['submit'])) {
    $emailOrUsername = $_POST['emailOrUsername'];
    $password = $_POST['password'];
    $passwordHash = hash("sha256", $password);

    $sql = "SELECT id, username, passwordHash, email FROM utilisateur WHERE username = ? OR email = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (hash_equals($row['passwordHash'], $passwordHash)) {
            $_SESSION["logged"] = $passwordHash;
            header("Location: ../Logic/Piece.php");
        } else {
            $error = "Mot de Passe incorrecte!";
        }
    } else {
        $error =  "Aucun Utilisateur trouvé";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Piece | Se Connecter</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <div class="page">
        <nav>
            <?php
            include "./include/Sidebar.php";
            Sidebar("login");
            ?>
        </nav>
        <main>
            <div class="justify-content-center align-items-center mt-10 mx-5 -container">
                <h1 class="title">Se Connecter</h1>
                <form onsubmit="return verifier();" method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>
                    <div class="form-group mt-2">
                        <label>Email ou Username:</label>
                        <input type="text" class="form-control" placeholder="E-mail ou Username" name="emailOrUsername" id="emailOrUsername">
                        <p id="eemailOrUsername"></p>
                    </div>
                    <div class="form-group mt-2">
                        <label>Mot de Passe</label>
                        <input type="password" class="form-control" placeholder="Mot de passe" name="password" id="password">
                        <p id="ePassword"></p>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" value="Se Connecter" name="submit">
                </form>
                <?php
                if ($error != "") echo  "<p class='feedback'>$error</p>";
                ?>
            </div>
        </main>
        <aside>

        </aside>
    </div>
    <script>
        function verifier() {

            let emailOrUsername = document.getElementById("emailOrUsername").value;
            let eemailOrUsername = document.getElementById("eemailOrUsername");

            let password = document.getElementById("password").value;
            let ePassword = document.getElementById("ePassword");

            let valider = true

            if (emailOrUsername.length == 0) {
                eemailOrUsername.innerHTML = "ce champ ne peut pas être vide"
                eemailOrUsername.classList.add("feedback");
                valider = false;
            } else {
                eemailOrUsername.innerHTML = "";
                eemailOrUsername.classList.remove("feedback");
            }

            if (password.length == 0) {
                ePassword.innerHTML = "ce champ ne peut pas être vide"
                ePassword.classList.add("feedback");
                valider = false;
            } else {
                ePassword.innerHTML = "";
                ePassword.classList.remove("feedback");

            }

            return valider
        }
    </script>
</body>

</html>