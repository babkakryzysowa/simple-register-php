<?php
 $genCodeActivation = time()+rand(0,9999);
echo '

<html>
<head>
    <link rel="stylesheet" href="http://kryzysowa.cal24.pl/zad/bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="http://www.kryzysowa.cal24.pl/zad/bootstrap/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>



<script>';
echo '
$(document).ready(function(){
$("#name").keyup(function(){
var name = $("#name").val();
 if(name.length >= 3)
{
$("#status").html(';
echo "


'Sprawdzam dostępność nicka...');";
echo '
$.post("data.php", {name: name}, function(data, status){
$("#statusName").html(data);
});
}
});
}); ';

echo '
$(document).ready(function(){
$("#mail").keyup(function(){
var mail = $("#mail").val();
 if(mail.length >= 3)
{
$("#statusEmail").html(';
echo "


'Sprawdzam dostępność maila...');";
echo '
$.post("data.php", {mail: mail}, function(data, status){
$("#statusEmail").html(data);
});
}
});
}); ';
echo  '
</script>

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
        <div class="col-sm-12">
        <p></p>
        </div>
        <div class="col-sm-12">
        </div>
        <div class="col-sm-4">
            <h2 class="form-signin-heading">Rejestracja</h2>
                <div id="login_form">
                    <div class="form-group">
                        <form action="register.php" method="POST">
                            <label for="labelEmail">E-mail</label>
                            <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" placeholder="Podaj email" name="mail" ><br />
                            <div id="statusEmail"></div>
                            <label for="labelNick">Nick</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Podaj nick" ><br />
                           <div id="statusName"></div>

                            <label for="labelPassword">Hasło</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Podaj hasło"><br />
                            <button type="submit" name="sub" class="btn btn-primary">Wyślij</button>
                        </form>
                    </div>
                </div>
        </div>';

        
$name = $_POST['name'];
$mail  = $_POST['mail'];
$password = $_POST['password'];

include('config.php');


$from  = "From: $mailFrom \r\n";
$from .= 'MIME-Version: 1.0'."\r\n";
$from .= 'Content-type: text/html; charset=utf-8'."\r\n";
$title = "Aktywacja konta w serwisie kryzysowa.cal24.pl.";
$msg = "<html>
<head>
</head>
<body>
   Witam serdecznie: <b>".$name."</b>! <br />
    Wejdź na adres:<br />".'<a href="'.$url."\">$url</a>.<br />
   Po kliknięciu Twoje konto zostanie aktywowane.
</body>
</html>";

if (isset($_POST['sub'])){

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
$sqlMail = $conn->prepare("SELECT * FROM users WHERE mail=:mail  ");
$sqlMail->bindValue(":mail", $mail);
$sqlMail->execute();

$countMail = $sqlMail->fetch();

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
$sqlNick = $conn->prepare("SELECT * FROM users WHERE name=:name  ");
$sqlNick->bindValue(":name", $name);
$sqlNick->execute();

$countNick = $sqlNick->fetch();


if ((is_array($countMail) )&& (is_array($countNick))) {
    echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.'Rejestracja nieudana: Podany mail i nick jest zajęty!</div></div>';
    exit;
}elseif(is_array($countMail)){
    echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.'Rejestracja nieudana: mail już istnieje w bazie!</div></div>';
    exit;
}elseif(is_array($countNick)){
    echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.'Rejestracja nieudana:  Nick już istnieje w bazie!</div></div>';
    exit;
}

 if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    echo $emailErr = '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'."Niepoprawny format maila.</div></div>"; 
    exit;
    }
    
try {

$active = 'N';
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
$insert =  $conn->prepare("insert into `users` (`name`, `mail`, `password`, `user_key`, `active`) values ( :name, :mail, :password, :user_key, :active) ");
$insert->bindParam(':name', strip_tags($name));
$insert->bindParam(':mail', $mail);
$insert->bindParam(':password', md5($password));
$insert->bindParam(':user_key', $genCodeActivation);
$insert->bindParam(':active', $active);

$insert->execute();
if ($insert =! 0){
        mail($mail, $title, $msg, $from);
		echo '<div class="col-sm-12"><div class="alert alert-success" role="alert">'."Rejestracja udana, sprawdź maila i aktywuj konto!</div></div>";
	}else{
		echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'."Wystąpił podczas rejestracji, spróbuj ponownie.</div></div>";

	}

}catch (Exception $e){
	echo 'Wystąpił podczas rejestracji, spróbuj ponownie.';
}

}


echo '
</body>
</html>';
?>
