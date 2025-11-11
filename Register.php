<?php
include "connection.php";
?>

<html lang="en" xmlns="">
<head>
    <title>User Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <!-- short column display for forms rows -->
    <div class="col-lg-4">
    <h2>User Registration Form</h2>
    <form action="" name="form1" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone number" name="phone" required>
        </div>
        <button type="submit" name="register" class="btn btn-default">Register</button>
        <a href="login.php" class="btn btn-default">Back to Login</a>
        </form>
    </div>
</div>


</body>

<!-- Registration processing -->
<?php
if(isset($_POST["register"]))
{
    $username = mysqli_real_escape_string($link, $_POST["username"]);
    $password = md5($_POST["password"]); 
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $phone = mysqli_real_escape_string($link, $_POST["phone"]);
    
    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($link, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        echo "<script type='text/javascript'>alert('Username already exists! Please choose another username.');</script>";
    } else {
        mysqli_query($link,"insert into users values (NULL,'$username','$password','$email','$phone')");
        ?>
        <script type="text/javascript">
            alert('Registration successful!');
            window.location.href='login.php';
        </script>
        <?php
    }
}
?>
</html>
