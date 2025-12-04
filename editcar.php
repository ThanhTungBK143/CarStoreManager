<?php
include "connection.php";
session_start();

// 1. CHECK LOGIN
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

// 2. CHECK ADMIN PERMISSION (Security Check)
$current_role = isset($_SESSION['role']) ? strtolower($_SESSION['role']) : '';
if ($current_role !== 'admin') {
    echo "<script>alert('Access Denied! Only Administrators can edit car details.'); window.location='car.php';</script>";
    exit();
}

// 3. GET CAR ID
if (!isset($_GET["id"])) {
    echo "<script>alert('Error: No product ID provided.'); window.location='car.php';</script>";
    exit();
}

$product_id = intval($_GET["id"]); // Sanitize ID

// Prepare variables
$message = "";
$message_type = "";

// 4. HANDLE UPDATE
if (isset($_POST["update"])) {
    $make     = mysqli_real_escape_string($link, $_POST["make"]);
    $model    = mysqli_real_escape_string($link, $_POST["model"]);
    $year     = intval($_POST["year"]);
    $color    = mysqli_real_escape_string($link, $_POST["color"]);
    $quantity = intval($_POST["quantity"]);
    $price    = floatval($_POST["price"]);

    // Update query (Fixed: Added Price column update)
    $update_query = "UPDATE cars 
                     SET make='$make', model='$model', year='$year', color='$color', 
                         quantity='$quantity', price='$price'
                     WHERE product_id = $product_id";

    if (mysqli_query($link, $update_query)) {
        $message = "Car details updated successfully!";
        $message_type = "success";
        // Refresh data after update to show new values immediately
    } else {
        $message = "Update failed: " . mysqli_error($link);
        $message_type = "danger";
    }
}

// 5. FETCH EXISTING DATA
$query = "SELECT * FROM cars WHERE product_id = $product_id";
$res = mysqli_query($link, $query);

if (!$res || mysqli_num_rows($res) == 0) {
    echo "<script>alert('Error: Car not found.'); window.location='car.php';</script>";
    exit();
}

$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Car Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">

    <style>
        body { background-color: #f8f9fc; font-family: 'Nunito', sans-serif; color: #5a5c69; }
        
        /* Navbar */
        .navbar-custom { background-color: #fff; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); }
        .navbar-brand { color: #4e73df !important; font-weight: 800; }
        
        /* Card Style */
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); margin-top: 50px; }
        
        .card-header-custom { 
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); 
            color: white; padding: 20px; font-weight: 700; text-align: center; border-radius: 15px 15px 0 0; 
        }
        
        /* Form Controls */
        .form-control { border-radius: 5px; height: 45px; font-size: 0.95rem; }
        .input-group-text { background-color: #f8f9fc; color: #4e73df; border: 1px solid #ced4da; }
        .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25); }

        /* Buttons */
        .btn-update { 
            background-color: #4e73df; color: white; border-radius: 50px; padding: 10px 30px; font-weight: bold; width: 100%; border: none;
        }
        .btn-update:hover { 
            background-color: #2e59d9; color: white; box-shadow: 0 4px 10px rgba(78, 115, 223, 0.4); transform: translateY(-2px); transition: all 0.3s;
        }
        
        .btn-back { border-radius: 50px; width: 100%; border: 2px solid #858796; color: #858796; font-weight: bold; padding: 10px 30px; text-align: center; display: block;}
        .btn-back:hover { background-color: #858796; color: white; text-decoration: none;}
    </style>
</head>
<body>

<nav class="navbar navbar-expand navbar-light navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="car.php">
            <i class="fas fa-arrow-left mr-2"></i> BACK TO INVENTORY
        </a>
        <span class="navbar-text ml-auto">Admin: <b><?php echo $_SESSION['username']; ?></b></span>
    </div>
</nav>

<div class="container" style="margin-top: 100px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
                    <?php if($message_type=='success') echo '<i class="fas fa-check-circle mr-2"></i>'; else echo '<i class="fas fa-exclamation-triangle mr-2"></i>'; ?>
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <i class="fas fa-edit mr-2"></i> EDIT CAR INFORMATION
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="" method="post">
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Make</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-industry"></i></span></div>
                                    <input type="text" class="form-control" name="make" value="<?php echo htmlspecialchars($row['make']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Model</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div>
                                    <input type="text" class="form-control" name="model" value="<?php echo htmlspecialchars($row['model']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Year</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                                    <input type="number" class="form-control" name="year" value="<?php echo htmlspecialchars($row['year']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Color</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-palette"></i></span></div>
                                    <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars($row['color']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Quantity (Stock)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-cubes"></i></span></div>
                                    <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Price (USD)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></div>
                                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col-6"><a href="car.php" class="btn btn-back">Cancel</a></div>
                            <div class="col-6"><button type="submit" name="update" class="btn btn-update">Save Changes</button></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>