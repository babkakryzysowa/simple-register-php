<?php
include('config.php');
if(isset($_POST['name'])){
	try {
    $name = $_POST['name'];
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $sqlNick = $conn->prepare("SELECT name FROM users WHERE name=:name  ");
    $sqlNick->bindValue(":name", $name);
    $sqlNick->execute();

    $count = $sqlNick->fetch();

    if ($count > 0){
            echo '<font color="red">'."Nick <b>".$name.'</b> jest zajęty.<font>';

        }else{
                echo '<font color="green">'."Nick <b>".$name.'</b> jest wolny.<font>';

        }
    }catch (Exception $e){
        echo 'Wystąpił problem ze sprawdzaniem nicku.';
    }
}


if(isset($_POST['mail'])){
	try {
    $mail = $_POST['mail'];
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $sqlMail = $conn->prepare("SELECT name FROM users WHERE mail=:mail  ");
    $sqlMail->bindValue(":mail", $mail);
    $sqlMail->execute();

    $count = $sqlMail->fetch();

    if ($count > 0){
            echo '<font color="red">'."Mail <b>".$mail.'</b> jest zajęty.<font>';

        }else{
            echo '<font color="green">'."Mail <b>".$mail.'</b> jest wolny.<font>';


        }
    }catch (Exception $e){
        echo 'Wystąpił problem ze sprawdzaniem maila.';
    }
}
?>	
