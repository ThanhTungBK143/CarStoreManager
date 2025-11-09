<?php
include "connection.php";
session_start();

if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

$username = $_SESSION['username'];
// --- Handle logout ---
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
// === DELETE CAR FUNCTION ===
if (isset($_GET['delete_car'])) {
    $id = intval($_GET['delete_car']);
    $query = "DELETE FROM cars WHERE product_id = $id";
    if (mysqli_query($link, $query)) {
        echo "<script>alert('Car deleted successfully!'); window.location='homepage.php';</script>";
    } else {
        echo "<script>alert('Error deleting car.'); window.location='homepage.php';</script>";
    }
    exit();
}

// === DELETE USER FUNCTION ===
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($link, $query)) {
        echo "<script>alert('User deleted successfully!'); window.location='homepage.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location='homepage.php';</script>";
    }
    exit();
}
?>

<html lang="en" xmlns="">
<head>
    <title>Store Manage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="position: relative; margin-top: 20px;">
    <h1 class="text-center">Welcome, <?php echo htmlspecialchars($username); ?> 👋</h1>
    <div class="header-buttons">
        <a 
        href="addcar.php" 
        class="btn btn-success"
        style="position: absolute; top: 0; left: -350px;" 
        onclick="return confirm('Do you want to add new car?');"
        >NEW CAR</a>
        <a 
        href="homepage.php?logout=true" 
        style="position: absolute; top: 0; right: -350px;"
        onclick="return confirm('Are you sure you want to log out?');" 
        class="btn btn-danger">Logout</a>
    </div>   
</div>
<!-- new column inserted for records -->
<!-- Search for boostrap table template online and copy code -->
<div class="col-lg-12">
    <h3 class="text-left">Cars Available in Store</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th>Model</th>
            <th>Year</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>Price</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($link)) {
            $res = mysqli_query($link, "SELECT * FROM cars");
        }

        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row['product_id']}</td>";
            echo "<td>{$row['make']}</td>";
            echo "<td>{$row['model']}</td>";
            echo "<td>{$row['year']}</td>";
            echo "<td>{$row['color']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td><a href='editcar.php?id={$row['product_id']}' class='btn btn-success'>Edit</a></td>";
            echo "<td><a 
                href='homepage.php?delete_car={$row['product_id']}'
                onclick=\"return confirm('Are you sure you want to delete this car?');\"
                class='btn btn-danger'>Delete</a>
                </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div class="col-lg-12">
    <h3 class="text-left">Registered Users</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <!-- Database connection -->
        <?php
        if (!empty($link)) {
            $res=mysqli_query($link,"select * from users");
        }
        while($row=mysqli_fetch_array($res))
        {
            echo "<tr>";
            echo "<td>"; echo $row["id"]; echo "</td>";
            echo "<td>"; echo $row["username"]; echo "</td>";
            echo "<td>"; echo $row["email"]; echo "</td>";
            echo "<td>"; echo $row["phone"]; echo "</td>";
            echo "<td>"; ?> <a href="edituser.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-success">Edit </button></a> <?php echo "</td>";
            echo "<td><a 
                href='homepage.php?delete_user={$row['id']}'
                onclick=\"return confirm('Are you sure you want to delete this user?');\"
                class='btn btn-danger'>Delete</a>
            </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>