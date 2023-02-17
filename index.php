<link rel="stylesheet" href="logowanko.css">
<?php
include 'logs.php';
session_start();
$connect = mysqli_connect("$host","$user","$pass","$karty");
?>

<?php // logowanie
if(isset($_POST['log']) && !empty($_POST['name']) && !empty($_POST['pass'])){
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    if(strlen($name) < 4){
        echo "<script>alert('Twoja nazwa jest zbyt krótka')</script>";
    } else{
        if(strlen($pass) < 6){
            echo "<script>alert('Twoje hasło jest zbyt krótkie')</script>";
        } else{
            $sql = "SELECT id, nazwa FROM `uzytkownicy` WHERE nazwa = '$name' AND haslo = '$pass'";
            $query = mysqli_query($connect,$sql);
            $user = mysqli_num_rows($query);
            if($user == 1){
                $row = mysqli_fetch_row($query);
                $_SESSION['id'] = $row[0]; 
                echo $_SESSION['id'];
                header('location: karty.php');
            } else{ echo "<script>alert('Nie znaleziono takiego użytkownika :(')</script>";}
        }
    }
}
?>



<main>   
<div class="form">
<form action="" method="post">
<span>Nick: </span><input type="text" name="name"><br>
<span>Hasło: </span> <input type="password" name="pass"><br>
<input type="submit" value="zaloguj" name="log"><br><br>
</form>
</div>  
<div class="a"><a href="rejestracja.php">Zarejestruj się</a></div>  
</main> 
