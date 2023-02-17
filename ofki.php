<link rel="stylesheet" href="stylecard.css">
<?php
include 'logs.php';
session_start();
$connect = mysqli_connect("$host","$user","$pass","$karty");
$id = $_SESSION['id'];
if(!isset($_SESSION['id'])){
    header('location: index.php');
    exit();
}

// obniżanie cen
if(!empty($_POST['ncena']) && isset($_POST['name'])){
    $ncena = $_POST['ncena'];
    $nazwa = $_POST['name'];
    $kid = $_POST['kid'];
    if($ncena < 0){
        echo "<script>alert('Cena musi wynosić conajmniej 1 coina')</script>";  
    }else{
    $sql ="UPDATE `karty` SET `cena` = '$ncena' WHERE `karty`.`id` = $kid;"; mysqli_query($connect,$sql);
    echo "<script>alert('Zmieniłeś cenę $nazwa, nowa cena wynosi $ncena coinów')</script>";}
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
    };}?>
<header class='baner'>  
    <section><img src="logom.png"></section>
    <section>
        <h1>Tu są twoje licytacje</h1>
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
<nav><a href='market.php'>market</a><a href='karty.php'>Wróć do kolekcji</a><a href='dodaj.php'>stwórz MGZ</a></nav>
<main>

<?php
$sql ="SELECT karty.id, karty.nazwa, karty.opis, karty.cena, karty.url, uzytkownicy1.nazwa AS uid_nazwa, uzytkownicy2.nazwa AS wid_nazwa, posiadane.uid AS uid_posiadane
FROM karty, uzytkownicy AS uzytkownicy1, uzytkownicy AS uzytkownicy2, posiadane
WHERE karty.id = posiadane.kid AND uzytkownicy1.id = posiadane.uid AND uzytkownicy2.id = posiadane.wid AND posiadane.market = 'T' AND uzytkownicy1.id = '$id'";
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
<input type='number' name='ncena'>
<input type='submit' value='zmień cenę'></form><br></div>";
}
?></main>

