<?php

$serveur = 'localhost';
$utilisateur = 'root';
$mot_de_passe = '';
$base_de_donnees = 'gestionpiece';

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("Échec de connexion : " . $connexion->connect_error);
} else {
    echo "<script> console.log('Connexion à la base de données réussie.')</script>";
}

?>
