<?php

function Sidebar($menu)
{
    echo "<div class='flex-column flex-shrink-0 p-3 bg-light h-100'>
    <a href='./' class='d-flex align-items-center link-dark text-decoration-none'>
        <img src='../assets/image/logo.png' width='100'>
    </a>
    <hr>
    <ul class='nav nav-pills flex-column mb-auto'>
        <li class='nav-item'>
            <a href='./Piece.php' class='nav-link" . ($menu == 'piece' ? ' active' : '') . "' aria-current='page'>
                Gestion Piece
            </a>
        </li>
        <li>
            <a href='./Commande.php' class='nav-link " .  ($menu == 'commande' ? ' active' : '') . "'>
                Gestion Commande
            </a>
        </li>
        <li>
            <a href='./Logout.php' class='nav-link link-dark'>
                Deconnexion
            </a>
        </li>
    </ul>
</div>";
}
