<?php
include "connection.php";
session_start();

// Nếu chưa đăng nhập thì đẩy về login
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

// Lấy ID user cần chỉnh sửa
$id = $_GET["id"];

// Khởi tạo biến
$username = "";
$email = "";
$phone = "";

// Lấy thông tin user từ DB
$res = mysqli_query($link, "SELECT * FROM users WHERE id = $id");
while ($row = mysqli_fetch_array($res)) {
    $username = $row["username"];
    $email = $row["email"];
    $phone = $row["phone"];
}
?>

<html lang="en">
<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="col-lg-4">
        <h2>Edit User Information</h2>

        <form action="" method="post" name="form1">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text"
                       class="form-control"
                       id="username"
                       name="username"
                       value="<?php echo htmlspecialchars($username); ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="<?php echo htmlspecialchars($email); ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text"
                       class="form-control"
                       id="phone"
                       name="phone"
                       value="<?php echo htmlspecialchars($phone); ?>"
                       required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="homepage.php" class="btn btn-default">Back</a>

        </form>
    </div>
</div>
</body>

<?php
// Xử lý cập nhật
if (isset($_POST["update"])) {
    $username = mysqli_real_escape_string($link, $_POST["username"]);
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $phone = mysqli_real_escape_string($link, $_POST["phone"]);

    mysqli_query($link, "
        UPDATE users 
        SET username='$username', email='$email', phone='$phone' 
        WHERE id = $id
    ");

    ?>
    <script type="text/javascript">
        alert("User updated successfully!");
        window.location="homepage.php";
    </script>
    <?php
}
?>
</html>
