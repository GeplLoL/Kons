# PHP TÖÖ Konsultatsioon
## Looge oma proosale ja koodile GitHubis lihtsa süntaksiga keerukas vorming.
### PHP kood, mis sisaldab veebisaidi peamist loogikat

Md-laiendiga fail on Markdowni dokument.
Markdown on kerge märgistuskeel, mis on loodud lihtsate märkide ja süntaksi abil teksti hõlpsaks vormindamiseks. 
See loodi eesmärgiga olla loetav ja hõlpsasti kirjutatav, kuid samas konverteeritav keerukamatesse vormingutesse, nagu HTML.

[Veebileht](https://denissgorjunov22.thkit.ee)

## Sisukord

[Uue Konsultatsioon lisamine](https://github.com/GeplLoL/Kons/blob/main/README.md#uue-konsultatsioon-lisamine)

[Konsultatsioon eemaldamine](https://github.com/GeplLoL/Kons/blob/main/README.md#konsultatsioon-eemaldamine)

[Juurdepääsuõiguste kontrollimine](https://github.com/GeplLoL/Kons/blob/main/README.md#juurdep%C3%A4%C3%A4su%C3%B5iguste-kontrollimine)

[Seansi juhtimine](https://github.com/GeplLoL/Kons/blob/main/README.md#seansi-juhtimine)



### Uue Konsultatsioon lisamine:
Kui päringus on parameeter nimi ja kasutaja on administraator, lisatakse uus konsultatsioon määratud andmetega.

### Konsultatsioon eemaldamine:
Kui päringus on parameeter konsDel ja kui kasutaja on administraator, siis määratud identifikaatorit kasutav konsultatsioon kustutatakse.

### Juurdepääsuõiguste kontrollimine:
Funktsiooni isAdmin() kasutatakse kontrollimaks, kas praegune kasutaja on administraator.

### Seansi juhtimine:
Seansi alustamiseks kasutage funktsiooni session_start(). Kood eeldab, et seansis salvestatakse teave administraatori oleku kohta.

```
<?php
require_once('config.php');
session_start();

if (isset($_POST["nimi"]) && !empty($_POST["nimi"])) {
    global $yhendus;
    if (isAdmin()) {
        $kask = $yhendus->prepare("INSERT INTO konsultatsioon (nimi, päev, tund, klassiruum, kommentaar, periood) VALUES (?, ?, ?, ?, ?, ?)");
        $kask->bind_param("ssssss", $_POST["nimi"], $_POST["päev"], $_POST["tund"], $_POST["klassiruum"], $_POST["kommentaar"], $_POST["periood"]);
        $kask->execute();
    }
    header("Location: haldusleht.php");
    $yhendus->close();
    exit();
}

if (isset($_GET["konsDel"]) && !empty($_GET["konsDel"])) {
    global $yhendus;
    if (isAdmin()) {
        $kask = $yhendus->prepare("DELETE FROM konsultatsioon WHERE id=?");
        $kask->bind_param("i", $_GET["konsDel"]);
        $kask->execute();
    }
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}

function isAdmin(){
    return isset($_SESSION['roll']) && $_SESSION['roll'];
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <script src="code.js"></script>
</head>
<body>
<header>
    <?php
    if (isset($_SESSION['kasutajanimi'])) {
        ?>
        <h1>Tere, <?= $_SESSION['kasutajanimi'] ?></h1>
        <a href="logout.php">Logi välja</a>
        <?php
    } else {
        ?>
        <a href="#" onclick="openModal()">Logi sisse</a>
        <a href="register.php">Register</a>
        <?php
    }
    ?>
</header>

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h1>Login</h1>
        <form id="loginForm" action="login.php" method="post">
            <label for="login">Login:</label>
            <input type="text" name="login" required>
            <br>
            <label for="pass">Password:</label>
            <input type="password" name="pass" required>
            <br>
            <input type="submit" value="Logi sisse">
        </form>
    </div>
</div>

<h1>Konsultatsioon</h1>
<h2>KasutajaLeht</h2>

<nav>
    <?php
    if (isAdmin()){
        echo "<a href='haldusleht.php'>Kasutaja</a>";
    }
    ?>
</nav>

<table>
    <tr>
        <th>Õpetaja nimi</th>
        <th>Päev</th>
        <th>Tund</th>
        <th>Periood</th>
        <th>Kommentaarid</th>
    </tr>
    <?php
    global $yhendus;
    $kask = $yhendus->prepare("SELECT id, nimi, päev, tund, kommentaar, periood FROM konsultatsioon");
    $kask->bind_result($id, $nimi, $paev,$tund, $kommentaar, $periood);
    $kask->execute();
    while ($kask->fetch()) {
        echo "<tr>";
        $tantsupaar = htmlspecialchars($nimi);
        echo "<td>" . $nimi . "</td>";
        echo "<td>" . $paev . "</td>";
        echo "<td>" . $tund . "</td>";
        echo "<td>" . $periood . "</td>";
        echo "<td>" . nl2br(htmlspecialchars($kommentaar)) . "</td>";
        echo "</tr>";
    }
    ?>
</table>
<?php
if(isset($_SESSION['kasutajanimi'])) {
    echo '
        <form action="" method="POST">
            <label for="nimi">Õpetaja nimi:</label>
            <input type="text" name="nimi" required>
            <br>
            <label for="päev">Päev:</label>
            <input type="text" name="päev" required>
            <br>
            <label for="tund">Tund:</label>
            <input type="text" name="tund" required>
            <br>
            <label for="klassiruum">Klassiruum:</label>
            <input type="text" name="klassiruum">
            <br>
            <label for="periood">periood:</label>
            <input type="text" name="periood">
            <br>
            <label for="kommentaar">Kommentaar:</label>
            <textarea name="kommentaar" rows="4" cols="50"></textarea>
            <br>
            <input type="submit" value="Lisa konsultatsioon">
        </form>';
}
?>
</body>
</html>
```

![image](https://github.com/GeplLoL/Tantsud/assets/85700200/60bcde1d-356f-44cb-a34a-2ec1171b2ca0)

## Kasutaja leht

![image](https://github.com/GeplLoL/Kons/assets/85700200/870320b0-c903-4ef8-9955-fbe254857977)

## Haldus leht
![image](https://github.com/GeplLoL/Kons/assets/85700200/6282602e-391d-4b53-a9fe-e59e36dd9b55)



Ülessanded:

Muutke modaalakna stiile,

suurendage teksti, 

muuda lehekülje registreerimise stiili

lisage uus admin õpetaja andmebaasi kaudu, 

Lisage saidi logo,

muutke vormi stiile,  

lisa mõnele objektile erinevad positsion
