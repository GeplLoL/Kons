<?php
require_once('config.php');
session_start();


if (isset($_POST["konsEdit"])) {
    global $yhendus;
    if (isAdmin()) {
        $field = $_POST['field'];
        $value = $_POST['value'];
        $id = $_POST['konsEdit'];

        switch ($field) {
            case "nimi":
                $kask = $yhendus->prepare("UPDATE konsultatsioon SET nimi=? WHERE id=?");
                break;
            case "päev":
                $kask = $yhendus->prepare("UPDATE konsultatsioon SET päev=? WHERE id=?");
                break;
            case "tund":
                $kask = $yhendus->prepare("UPDATE konsultatsioon SET tund=? WHERE id=?");
                break;
            case "kommentaar":
                $kask = $yhendus->prepare("UPDATE konsultatsioon SET kommentaar=? WHERE id=?");
                break;
            case "periood":
                $kask = $yhendus->prepare("UPDATE konsultatsioon SET periood=? WHERE id=?");
                break;
            default:
                echo "error";
                exit();
        }

        $kask->bind_param("si", $value, $id);
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

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Konsultatsioonide haldus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <?php
    if (isset($_SESSION['kasutajanimi'])) {
        echo "<h1>Tere, {$_SESSION['kasutajanimi']}</h1>";
        echo "<a href='logout.php'>Logi välja</a>";
    } else {
        echo "<a href='login.php' >Logi sisse</a>";
        echo "<a href='register.php'>Register</a>";
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

<h1>Konsultatsioonide haldus</h1>
<h2>AdminLeht</h2>

<nav>
    <?php
    if (isAdmin()){
        echo "<a href='adminleht.php'>Admin</a>";
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
        <th>Действия</th>
    </tr>
    <?php
    global $yhendus;
    $kask = $yhendus->prepare("SELECT id, nimi, päev, tund, kommentaar, periood FROM konsultatsioon");
    $kask->bind_result($id, $nimi, $paev, $tund, $kommentaar, $periood);
    $kask->execute();
    while ($kask->fetch()) {
        echo "<tr>";
        echo "<td><form action='' method='POST'><input type='hidden' name='konsEdit' value='$id'><input type='text' name='value' value='$nimi'><input type='hidden' name='field' value='nimi'><input type='submit' value='Edit'></form></td>";
        echo "<td><form action='' method='POST'><input type='hidden' name='konsEdit' value='$id'><input type='text' name='value' value='$paev'><input type='hidden' name='field' value='päev'><input type='submit' value='Edit'></form></td>";
        echo "<td><form action='' method='POST'><input type='hidden' name='konsEdit' value='$id'><input type='text' name='value' value='$tund'><input type='hidden' name='field' value='tund'><input type='submit' value='Edit'></form></td>";
        echo "<td><form action='' method='POST'><input type='hidden' name='konsEdit' value='$id'><input type='text' name='value' value='$periood'><input type='hidden' name='field' value='periood'><input type='submit' value='Edit'></form></td>";
        echo "<td><form action='' method='POST'><input type='hidden' name='konsEdit' value='$id'><textarea name='value'>$kommentaar</textarea><input type='hidden' name='field' value='kommentaar'><input type='submit' value='Edit'></form></td>";
        echo "<td>";
        if (isAdmin()) {
            echo "<a href='?konsDel=$id'>Kustutamine</a>";
        }
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
