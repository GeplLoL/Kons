<?php
require_once("config.php");
session_start();

if (isset($_SESSION['kasutajanimi']) && isset($_SESSION['id']))
    header("Location: ./index.php");

if (isset($_POST['registerBtn'])){
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $passwd_again = $_POST['passwd_again'];
    global $yhendus;

    $kask = $yhendus->prepare("SELECT * FROM kasutajad WHERE kasutajanimi=?");
    $kask->bind_param("s", $username);
    $kask->execute();

    if (!$kask->fetch()){
        if ($username != "" && $passwd != "" && $passwd_again != ""){
            if ($passwd === $passwd_again){
                if ( strlen($passwd) >= 5 && strpbrk($passwd, "!#$.,:;()")){
                    mysqli_query($yhendus, "INSERT INTO kasutajad (kasutajanimi, parool, roll) VALUES ('$username', '$passwd',  'tavakasutaja')");
                    $query = mysqli_query($yhendus, "SELECT * FROM kasutajad WHERE kasutajanimi='{$username}'");
                    if (mysqli_num_rows($query) == 1){
                        $success = true;
                    }
                }
                else
                    $error_msg = 'Your password is not strong enough. Please use another.';
            }
            else
                $error_msg = 'Your passwords did not match.';
        }
        else
            $error_msg = 'Please fill out all required fields.';
    }
    else {
        $error_msg = 'The username <i>'.$username.'</i> is already taken. Please use another.';
    }
}
else {
    $error_msg = 'An error occurred and your account was not created.';
}
?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<form action="./register.php" class="form" method="POST">
    <h1>Registreeri uus kasutaja</h1>
    <div class="">
        <?php
        if (isset($success) && $success){
            echo '<p style="color: green;">Yay!! Your account has been created. <a href="./login.php">Click here</a> to login!<p>';
        }
        else if (isset($error_msg)) {
            echo '<p style="color: red;">'.$error_msg.'</p>';
        }
        ?>
    </div>
    <div class="">
        <input type="text" name="username" value="" placeholder="enter a username" autocomplete="off" required />
    </div>
    <div class="">
        <input type="password" name="passwd" value="" placeholder="enter a password" autocomplete="off" required />
    </div>
    <div class="">
        <p>parool peab olema vähemalt 5 tähemärgi pikkune ja<br /> sisaldama erimärki, nt. !#$.,:;()</p>
    </div>
    <div class="">
        <input type="password" name="passwd_again" value="" placeholder="confirm your password" autocomplete="off" required />
    </div>
    <div class="">
        <input class="" type="submit" name="registerBtn" value="create account" />
    </div>
    <p class="center"><br />
        Already have an account? <a href="login.php">Login here</a>
    </p>
</form>
