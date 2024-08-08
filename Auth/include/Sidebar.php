<?php 

function Sidebar($menu){
    echo "<div class='flex-column flex-shrink-0 p-3 bg-light h-100'>
    <a href='./' class='d-flex align-items-center link-dark text-decoration-none'>
        <img src='../assets/image/logo.png' width='100'>
    </a>
    <hr>
    <ul class='nav nav-pills flex-column mb-auto'>
        <li class='nav-item'>
            <a href='./Login.php' class='nav-link". ($menu == 'login' ? ' active' : '') ."' aria-current='page'>
                Se Connecter
            </a>
        </li>
        <li>
            <a href='./SignUp.php' class='nav-link". ($menu == 'signup' ? ' active' : '') ."'>
                S'inscrire
            </a>
        </li>
    </ul>
</div>";
}

?>
