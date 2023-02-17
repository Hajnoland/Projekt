<link rel="stylesheet" href="rej.css">
<?php
include 'logs.php';
session_start();
$connect = mysqli_connect("$host","$user","$pass","$karty");
?>

<?php // rejestrowanie
if(isset($_POST['log']) && !empty($_POST['name']) && !empty($_POST['pass']) && !empty($_POST['pass2'])){

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass2 = filter_var($_POST['pass2'], FILTER_SANITIZE_STRING);

    $check = 0;
    if(strlen($name) < 4){
        echo "<script>alert('Twoja nazwa jest zbyt krótka')</script>";
    } else{
        if(strlen($pass) < 6){
            echo "<script>alert('Twoje hasło jest zbyt krótkie')</script>";
        } else{
            if($pass!== $pass2 ){
                echo "<script>alert('Hasła nie są takie same')</script>";   
            } else{
            $sql="SELECT `nazwa` FROM `uzytkownicy`";
            $query = mysqli_query($connect,$sql);
            while($row = mysqli_fetch_row($query)){
                if($row[0] == $name){
                    $check++;
                };
                };
                if($check == 0){
                $sql = "INSERT INTO `uzytkownicy` (`id`, `nazwa`, `haslo`, `kasa`) VALUES (NULL, '$name', '$pass', '0');";
                mysqli_query($connect,$sql);
                header('location: index.php');
            }else{
                    echo "<script>alert('użytkownik o podanym nicku już istnieje')</script>";  }
            }
        }
    }
} 
   

?>

<main>   
<div class="form">
<form action="" method="post">
<span>Nick: </span><input type="text" name="name"><br>
<span>Hasło: </span> <input type="password" name="pass"><br>
<span>Powtórz hasło: </span> <input type="password" name="pass2"><br>
<input type="submit" value="zaloguj" name="log">
</form>
</div>  
<div class="a"><a href="index.php">Zaloguj się</a></div>  
</main> 