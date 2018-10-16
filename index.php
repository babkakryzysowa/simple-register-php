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
    <div class="col-sm-12">
    <p></p>
    </div>
    <div class="col-sm-12">
    </div>
    <div class="col-sm-4">
        <h2 class="form-signin-heading">Logowanie</h2>
            <div id="login_form">
                <div class="form-group">
                    <form action="index.php" method="POST">
                        <label for="labelNick">Nick</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Podaj nick"><br />
                        <label for="labelPassword">Hasło</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Podaj hasło"><br />
                        <button type="submit" name="sub" class="btn btn-primary">Wyślij</button>
                    </form>
                </div>
            </div>
    </div>
';
$name = $_POST['name'];
$password = $_POST['password'];
$active = 'T';

if (isset($_POST['sub'])){
    try {
        include('config.php');
        $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
        $select = $conn->prepare("SELECT * FROM users WHERE name=:name AND password = :password");
        $select->bindValue(":name", $name);
        $select->bindValue(":password", md5($password));

        $count = $select->execute();
        $select->setFetchMode(PDO::FETCH_ASSOC);	  

            $row = $select->fetch();
            if ($select != 0 ) {
                if($row['active'] === 'T'){
                $_POST['name_get'] = $row['name'];
                session_start();
                 $_SESSION['name_get'] = $row['name'];
                header('Location: start.php');

                }else{
                        echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.'Niepoprawne dane logowania lub użytkownik nie został jeszcze aktywowany (proszę sprawdzić adres e-mail).</div></div>';
                }
            }

        }catch (Exception $e){
      
                    echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.'Niestety nie ma takiego użytkownika w bazie.</div></div>';
                
                }
}
echo '</div>
</body>
</html>';

?>
