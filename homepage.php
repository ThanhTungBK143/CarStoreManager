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
<style>
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap; /* keeps layout clean on mobile */
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.header-bar h1 {
    flex: 1;
    text-align: center;
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}
.header-bar .btn {
    min-width: 100px;
}
.header-bar {
    position: sticky;
    top: 0;
    z-index: 1000;
}
</style>

<div class="container mt-4">
    <div class="header-bar">
        <a 
            href="addcar.php" 
            class="btn btn-success"
            onclick="return confirm('Do you want to add new car?');">
            NEW CAR
        </a>

        <h1>Welcome, <?php echo htmlspecialchars($username); ?> 👋</h1>

        <a 
            href="homepage.php?logout=true" 
            class="btn btn-danger"
            onclick="return confirm('Are you sure you want to log out?');">
            LOGOUT
        </a>
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