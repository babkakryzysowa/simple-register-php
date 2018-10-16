<?php
echo '
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://kryzysowa.cal24.pl/zad/bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="http://www.kryzysowa.cal24.pl/zad/bootstrap/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">Logowanie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="register.php">Rejestracja</a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link"  href="start.php?logout">Wyloguj</a>
    </li>
  </ul>

</nav>

<div class="container bg-light text-dark">
    <div class="col-sm-12">
    <p></p>
    </div>
    <div class="col-sm-12">
    </div>
    <div class="col-sm-4">
        <h2 class="form-signin-heading">Konto użytkownika</h2>
            
    </div>
';

session_start();
echo 'Nick: <b>'. $_SESSION['name_get'].'</b>';
$name = $_SESSION['name_get'];

             
echo '</div>
</body>
</html>';


if (isset($_GET['logout'])){
unset($_SESSION['name_get']);
session_destroy();
header('Location: index.php');

}


?>
