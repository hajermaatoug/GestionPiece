<?php
session_start();
if (isset($_SESSION['logged'])) {
    header("Location: ../Logic/Piece.php");
}
include "connect.php";

$created = false;
$error = "";

if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordHash = hash("sha256", $password);

    $checkQuery = "SELECT COUNT(*) as count FROM utilisateur WHERE email = ? OR username = ?";
    $checkStmt = $connexion->prepare($checkQuery);
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $row = $checkResult->fetch_assoc();
    if ($row['count'] > 0) {
        $error = "L'e-mail ou le nom d'utilisateur existe déjà.";
    } else {
        $sql = "INSERT INTO `utilisateur` (`username`, `passwordHash`, `email`) VALUES (?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sss", $username, $passwordHash, $email);

        if ($stmt->execute()) {
            $created = true;
        } else {
            echo "Error: " . $sql . "<br>" . $connexion->error;
        }
    }
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
            <?php include "./include/Sidebar.php"; 
            Sidebar("signup"); ?>
        </nav>
        <main>
            <div class="justify-content-center align-items-center mt-10 mx-5 -container">
                <h1 class="title">S'inscrire</h1>
                <?php
                if ($created) {
                    echo "<div class='mb-5 center'>
                        <span class='success'>Utilisateur Inscrit</span>
                        </div>";
                } else if ($error) {
                    echo "<div class='mb-5 center'>
                        <span class='fail'>$error</span>
                        </div>";
                }
                ?>
                <form onsubmit="return verifier();" method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>
                    <div class="form-group mt-2">
                        <label>Email :</label>
                        <input type="email" class="form-control" placeholder="E-mail" name="email">
                        <small class="form-text text-sm text-muted">Nous ne partagerons jamais votre e-mail avec quelqu'un d'autre.</small>
                    </div>
                    <div class="form-group mt-2">
                        <label>Username:</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                        <p id="eUsername"></p>
                    </div>
                    <div class="form-group mt-2">
                        <label>Mot de Passe</label>
                        <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password">
                        <p id="ePassword"></p>
                    </div>
                    <div class="form-group mt-2">
                        <label>Confirmer Mot de Passe</label>
                        <input type="password" class="form-control" placeholder="Confirmer" id="confirme" name="confirme">
                        <p id="eConfirme"></p>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" value="S'inscrire" name="submit">
                </form>
            </div>
        </main>
        <aside></aside>
    </div>
    <script>
        function isAlpha(c) {
            return /^[a-zA-Z]$/.test(c);
        }

        function verifier() {
            let password = document.getElementById("password").value;
            let ePassword = document.getElementById("ePassword");

            let confirme = document.getElementById("confirme").value;
            let eConfirme = document.getElementById("eConfirme");

            let username = document.getElementById('username').value;
            let eUsername = document.getElementById('eUsername');

            let valider = true

            if (password.length < 8) {
                ePassword.innerHTML = "Le mot de passe doit comporter 8 caractères"
                ePassword.classList.add("feedback");
                valider = false;
            } else {
                ePassword.innerHTML = "";
                ePassword.classList.remove("feedback");
            }

            if (password != confirme) {
                eConfirme.innerHTML = "Le mot de passe ne correspond pas"
                eConfirme.classList.add("feedback");
                valider = false;
            } else {
                eConfirme.innerHTML = "";
                eConfirme.classList.remove("feedback");
            }

            if (username.length > 0 && !isAlpha(username.charAt(0))) {
                eUsername.innerHTML = "le premier caractère doit etre alphabetique"
                eUsername.classList.add("feedback");
                valider = false;
            } else if (username.length < 4) {
                eUsername.innerHTML = "le nom d'utilisateur doit comporter 4 caractères"
                eUsername.classList.add("feedback");
                valider = false;
            } else {
                eUsername.innerHTML = "";
                eUsername.classList.remove("feedback");
            }

            return valider
        }
    </script>
</body>

</html>
