<?php
require_once("config.php");
global $yhendus;
session_start();
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    $kask = $yhendus->prepare("SELECT kasutajanimi, roll FROM kasutajad WHERE kasutajanimi=? AND parool=?");
    $kask->bind_param("ss", $login, $pass);
    $kask->bind_result($kasutajanimi, $roll);
    $kask->execute();

    if ($kask->fetch()) {
        $_SESSION['kasutajanimi'] = $login;
        $_SESSION['roll'] = $roll;

        if ($roll == 'admin') {
            header("location: adminleht.php");
            exit();
        } else {
            header("location: haldusleht.php");
            $yhendus->close();
            exit();
        }
    } else {
        echo "Kasutajanimi $login või parool on vale";
        $yhendus->close();
    }
}
?>

<h1>Login</h1>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
