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
  </ul>

</nav>


<div class="container bg-light text-dark">
    <h2 class="form-signin-heading">Aktywacja</h2>';

$key =  $_GET['key'];
$mail = $_GET['mail'];


try {
    include('config.php');
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $select = $conn->prepare("SELECT * FROM users WHERE user_key=:key AND mail = :mail ");
    $select->bindValue(":key", $key);
    $select->bindValue(":mail", $mail);
    $count = $select->execute();
    $select->setFetchMode(PDO::FETCH_ASSOC);	  
    while($row = $select->fetch()){
        $row['id'];
        $row['active'];
        $active = 'T';
        $id = $row['id'];
        
        if ($row['active'] === 'T'){
            echo 'Konto zostało już wcześniej aktywowane.';
        }else {
            $update = $conn->prepare("UPDATE users SET active = :active WHERE id  = :id ");
            $update->bindValue(":active", $active);
            $update->bindValue(":id", $id);
            $count = $update->execute();
        
            if ($count != 0) {
                echo 'Konto zostało poprawnie aktywowane!';
            }else {
                echo 'Konto nie zostało aktywowane.';

            }
        }   
    }

}catch (Exception $e){
	echo 'Niestety nie ma takiego użytkownika w bazie.';
}

echo '</div>
</body>
</html>';
?> 
