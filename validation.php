<?php
session_start();
include "connection.php";

$name = $_POST['username'];
$pass = $_POST['password'];

$s = "SELECT * FROM users WHERE username='$name' AND password='$pass'";
$result = mysqli_query($link, $s);

$num = mysqli_num_rows($result);

if ($num == 1) {
    $_SESSION['username'] = $name;
    header('Location: homepage.php');
    exit();
} else {
    echo "Invalid username or password";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
}
?>
