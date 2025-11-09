<?php
include "connection.php";
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
    exit();
}


// Check if id exists
if (!isset($_GET["id"])) {
    die("<h3 style='color:red;'>❌ Error: No product ID provided.</h3>");
}

$product_id = intval($_GET["id"]); // sanitize the ID

// Prepare variables
$make = $model = $year = $color = $quantity = $price = "";

// Fetch existing car data
$query = "SELECT * FROM Cars WHERE product_id = $product_id";
$res = mysqli_query($link, $query);

if (!$res || mysqli_num_rows($res) == 0) {
    die("<h3 style='color:red;'>❌ Error: No car found with ID = $product_id.</h3>");
}

$row = mysqli_fetch_assoc($res);
$make     = $row["make"];
$model    = $row["model"];
$year     = $row["year"];
$color    = $row["color"];
$quantity = $row["quantity"];
$price    = $row["price"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Car</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <div class="col-lg-6">
        <h2>Edit Car Information</h2>
        <form method="post">
            <div class="form-group">
                <label>Make:</label>
                <input type="text" class="form-control" name="make" value="<?php echo htmlspecialchars($make); ?>">
            </div>
            <div class="form-group">
                <label>Model:</label>
                <input type="text" class="form-control" name="model" value="<?php echo htmlspecialchars($model); ?>">
            </div>
            <div class="form-group">
                <label>Year:</label>
                <input type="text" class="form-control" name="year" value="<?php echo htmlspecialchars($year); ?>">
            </div>
            <div class="form-group">
                <label>Color:</label>
                <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars($color); ?>">
            </div>
            <div class="form-group">
                <label>Quantity:</label>
                <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="homepage.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
</body>

<?php
if (isset($_POST["update"])) {
    $make     = mysqli_real_escape_string($link, $_POST["make"]);
    $model    = mysqli_real_escape_string($link, $_POST["model"]);
    $year     = mysqli_real_escape_string($link, $_POST["year"]);
    $color    = mysqli_real_escape_string($link, $_POST["color"]);
    $quantity = mysqli_real_escape_string($link, $_POST["quantity"]);
    $price    = mysqli_real_escape_string($link, $_POST["price"]);

    $update = "UPDATE Cars 
               SET make='$make', model='$model', year='$year', color='$color',
                   quantity='$quantity', price='$price'
               WHERE product_id = $product_id";

    if (mysqli_query($link, $update)) {
        echo "<script>
            alert('✅ Car record updated successfully!');
            window.location = 'homepage.php';
        </script>";
    } else {
        echo "<h4 style='color:red;'>❌ Update failed: " . mysqli_error($link) . "</h4>";
    }
}
?>
</html>
