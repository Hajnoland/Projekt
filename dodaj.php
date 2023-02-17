
<body>
<link rel="stylesheet" href="dod.css">
</body>

<?php
include 'logs.php';
session_start();
$connect = mysqli_connect("$host","$user","$pass","$karty");
if(!isset($_SESSION['id'])){
    header('location: index.php');
    exit();
}
$id = $_SESSION['id'];
//tworzenie karty
if(!empty($_POST['tytul']) && !empty($_POST['opis']) && !empty($_POST['cena']) && !empty($_POST['url'])){
    $tytul = filter_var($_POST['tytul'], FILTER_SANITIZE_STRING);
    $opis = filter_var($_POST['opis'], FILTER_SANITIZE_STRING);
    $cena =  $_POST['cena'];
    $url = $_POST['url'];
    if($cena < 0){
        echo "<script>alert('Cena musi wynosić conajmniej 1 coina')</script>";  
    }else{
        if(isset($_POST['url'])) {
            $url = $_POST['url'];
            $prefix1 = "https://media.discordapp.net/attachments/";
            $prefix2 = "https://cdn.discordapp.com/attachments/";
            if(substr($url, 0, strlen($prefix1)) != $prefix1 && substr($url, 0, strlen($prefix2)) != $prefix2) {
              echo "<script>alert('Wprowadzony link musi być linkiem do discorda ')</script>";
            } else {
    $sql ="INSERT INTO `karty` (`id`, `nazwa`, `opis`, `cena`, `url`) VALUES (NULL, '$tytul', '$opis', '$cena', '$url');";mysqli_query($connect,$sql);
    $sql = "SELECT karty.id FROM karty ORDER BY karty.id DESC";
    $query = mysqli_query($connect,$sql);
    $row = mysqli_fetch_row($query);
    $ckid = $row[0];
    $sql ="INSERT INTO `posiadane` (`id`, `kid`, `uid`, `wid`, `market`) VALUES (NULL, '$ckid', '$id', '$id', 'T')";mysqli_query($connect,$sql);
    header('location: ofki.php');
    echo "<script>alert('Dodałeś nową kartę o id $ckid')</script>";}
        }
    }
}
?>
<main>   
<div class="form">
<form method='post' >
<input type='text' name='tytul' placeholder="nazwa karty"><br>
<input type='text' name='opis' placeholder="opis karty"><br>
<input type='number' name='cena' placeholder="cena"><br>
<input type='text' name='url'placeholder="link do obrazu"><br>
<input type='submit' value='Stwórz własne MGZ!!'>
</form>
</div>  
<div class="a"><a href="karty.php">Twoje karty</a></div>  
</main> 


