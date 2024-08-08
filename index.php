<?php
session_start();

if (isset($_SESSION["logged"])){
    header("Location: ./Logic/Piece.php");
} else {
    header("Location: ./Auth/Login.php");
}
?>