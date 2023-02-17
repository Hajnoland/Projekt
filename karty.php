
<!DOCTYPE html>
<body>
<link rel="stylesheet" href="stylecard.css">
<meta http-equiv="refresh" content="60">
</body>
<html>
<?php 
include 'logs.php';
session_start();
$connect = mysqli_connect("$host","$user","$pass","$karty");

if(!isset($_SESSION['id'])){
    header('location: index.php');
    exit();
}

// Wstawianie nowych
if(!empty($_POST['ncena']) && isset($_POST['name'])){
    $ncena = $_POST['ncena'];
    $nazwa = $_POST['name'];
    $kid = $_POST['kid'];
    if($ncena < 0){
        echo "<script>alert('Cena musi wynosić conajmniej 1 coina')</script>";  
    }else{
        $check = mysqli_querry($baza, "SELECT cena FROM `karty` WHERE karty.id = $kid");
foreach($check as $c){
if($ncena == $c['cena']){
$sql ="UPDATE `karty` SET `cena` = '$ncena' WHERE `karty`.`id` = $kid;"; mysqli_query($connect,$sql);
$sql = "UPDATE `posiadane` SET `market` = 'T' WHERE `posiadane`.`kid` = $kid;";mysqli_query($connect,$sql);
echo "<script>alert('Dodano $nazwa na market za $ncena coinów!!')</script>";}
else{
echo "NT Kapi";
}
}
}
}






//wylogowywanie
if(isset($_POST['wyloguj'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
}
//baner
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $sql = "SELECT nazwa, FLOOR(kasa) FROM uzytkownicy WHERE id = $id";
    $query = mysqli_query($connect,$sql);
    while($row = mysqli_fetch_row($query)){
        $nazwa = $row[0]; $kasa = $row[1];
    };}
?>


<header class='baner'>  
    <section><img src="logom.png"></section>
    <section>
        <h1>Witaj w MGZ Shopcenter!!</h1>
    </section>
    <?php echo"<section>
    <h3>Twój nick:<span class='span'> $nazwa </span>
    <br>Twoja ilość coinów: <span class='span2'>$kasa $</span><br>
    </h3></section>"?>


    <section>
    <form method="post">
    <input type="submit" name="wyloguj" value="wyloguj">
    </form>
    </section>
</header>  
<nav><a href='market.php'>market</a><a href='ofki.php'>Sprawdz twoje oferty</a><a href='dodaj.php'>stwórz MGZ</a></nav>
<main>

<?php
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $sql ="SELECT karty.id, karty.nazwa, karty.opis, karty.cena, karty.url, uzytkownicy1.nazwa AS uid_nazwa, uzytkownicy2.nazwa AS wid_nazwa
    FROM karty, uzytkownicy AS uzytkownicy1, uzytkownicy AS uzytkownicy2, posiadane
    WHERE karty.id = posiadane.kid AND uzytkownicy1.id = posiadane.uid AND uzytkownicy2.id = posiadane.wid AND uzytkownicy1.id = $id AND posiadane.market = 'N'";
    $query = mysqli_query($connect,$sql);
    while($row = mysqli_fetch_row($query)){
        echo"<div class='card'>
        <p class='idk'>$row[0]</p>
        <p class='n'>$row[1]</p>
        <p class='img'><img src='$row[4]' alt='$row[2]' height='250px' widht='250px'></p>
        <p class='opis'>$row[2]</p>
        <p class='cena'>cena za to gówno: $row[3] $</p>
        <p class='wlk'>właściciel karty: $row[5]</p>
        <p class='autor'>autor karty: $row[6]</p>
    <form method='post'>
    <input type='hidden' value='$row[0]' name='kid'>
    <input type='hidden' value='$row[1]' name='name'>
    <input type='number' name='ncena'><br>
    <input type='submit' value='Wstaw na rynek'></form><br></div>";
    
    }
   }

?></main>
<script>
function updateData() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "karty.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
        }
    }
    xhr.send();
    setTimeout(updateData, 500);
}
updateData();
</script>
<?php
    $sql = "SELECT `id`, `nazwa`, `haslo`, `kasa` FROM `uzytkownicy` WHERE id = $id;";
    $query = mysqli_query($connect,$sql);
    $row = mysqli_fetch_row($query);
    $zarobek = $row[3];
    $zarobek = $zarobek + 0.0175;
    $sql = "UPDATE `uzytkownicy` SET `kasa` = '$zarobek' WHERE `uzytkownicy`.`id` = $id;";
    mysqli_query($connect,$sql);
?></html>