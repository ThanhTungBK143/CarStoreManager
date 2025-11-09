<?php
include "connection.php"; // kết nối DB
?>

<html lang="en">
<head>
    <title>Car Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="col-lg-4">
    <h2>Car Registration Form</h2>
    <form action="" name="carForm" method="post">
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" class="form-control" id="make" placeholder="Enter car make" name="make" required>
        </div>

        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" placeholder="Enter car model" name="model" required>
        </div>

        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" placeholder="Enter year" name="year" min="1900" max="2099" required>
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" placeholder="Enter color" name="color" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity" min="1" required>
        </div>

        <div class="form-group">
            <label for="price">Price (USD):</label>
            <input type="number" step="0.01" class="form-control" id="price" placeholder="Enter price" name="price" required>
        </div>

        <button type="submit" name="insert" class="btn btn-primary">Insert</button>
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
    </form>
</div>

<div class="col-lg-12 mt-4">
    <h2>Car Records</h2>
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Price (USD)</th>
                <th>Action</th> <!-- Thêm cột Action -->
            </tr>
        </thead>
        <tbody>
        <?php
        $res = mysqli_query($link, "SELECT * FROM Cars");
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td>" . $row["make"] . "</td>";
            echo "<td>" . $row["model"] . "</td>";
            echo "<td>" . $row["year"] . "</td>";
            echo "<td>" . $row["color"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "<td>
                    <a href='edit.php?id=" . $row["product_id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>


<?php
// INSERT
if(isset($_POST["insert"])) {
    $make = mysqli_real_escape_string($link, $_POST['make']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $year = (int)$_POST['year'];
    $color = mysqli_real_escape_string($link, $_POST['color']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];

    mysqli_query($link,"INSERT INTO Cars (make, model, year, color, quantity, price) 
                        VALUES ('$make','$model','$year','$color','$quantity','$price')");
    echo "<script>window.location.href=window.location.href;</script>";
}

// DELETE
if(isset($_POST["delete"])) {
    $make = mysqli_real_escape_string($link, $_POST['make']);
    $model = mysqli_real_escape_string($link, $_POST['model']);

    // Xóa theo make + model để tránh xóa nhầm
    mysqli_query($link,"DELETE FROM Cars WHERE make='$make' AND model='$model'");
    echo "<script>window.location.href=window.location.href;</script>";
}

?>
</body>
</html>
