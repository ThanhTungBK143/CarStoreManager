<?php
include "connection.php";
session_start();

// Redirect user if not logged in
if(!isset($_SESSION['username'])){
    header('location:login.php');
    exit();
}

// Chỉ cho phép ADMIN hoặc SALE truy cập (Tùy logic của bạn, ở đây tôi để cả 2)
// $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'sale'; 

$message = ''; 
$message_type = ''; 

if(isset($_POST["insert"])) {
    // 1. Sanitize inputs
    $make = mysqli_real_escape_string($link, $_POST['make']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $year = (int)$_POST['year'];
    $color = mysqli_real_escape_string($link, $_POST['color']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];

    $result = false; 

    // 2. Check if car already exists
    $check_query = "SELECT * FROM cars 
                    WHERE make='$make' AND model='$model' AND year='$year' AND color='$color'";
    $res = mysqli_query($link, $check_query);

    if($res === false) {
        $message = "Database Error: " . mysqli_error($link);
        $message_type = 'danger';
    } else {
        $num_rows = mysqli_num_rows($res);

        if($num_rows > 0) {
            // Update existing car
            $row = mysqli_fetch_array($res);
            $old_quantity = $row["quantity"];
            $new_quantity = $old_quantity + $quantity;

            $update_query = "UPDATE cars SET quantity='$new_quantity', price='$price' 
                            WHERE make='$make' AND model='$model' AND year='$year' AND color='$color'";
            $result = mysqli_query($link, $update_query);
            
            if($result) {
                $message = "<strong>Updated!</strong> Added $quantity to existing stock. Total: $new_quantity.";
                $message_type = 'success';
            } else {
                $message = "Update Failed: " . mysqli_error($link);
                $message_type = 'danger';
            }
        } else {
            // Insert new car
            $insert_query = "INSERT INTO cars (make, model, year, color, quantity, price) 
                            VALUES ('$make','$model','$year','$color','$quantity','$price')";
            $result = mysqli_query($link, $insert_query);
            
            if($result) {
                $message = "<strong>Success!</strong> New car '$make $model' added to inventory.";
                $message_type = 'success';
            } else {
                $message = "Insert Failed: " . mysqli_error($link);
                $message_type = 'danger';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Car</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            color: #5a5c69;
        }

        /* Navbar */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
        }
        .navbar-brand {
            color: #4e73df !important;
            font-weight: 800;
        }

        /* Card Style */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        /* Form Controls */
        .form-control {
            border-radius: 5px;
            height: 45px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .input-group-text {
            background-color: #f8f9fc;
            border-right: none;
            color: #4e73df;
        }
        .input-group .form-control {
            border-left: none;
        }
        
        /* Buttons */
        .btn-submit {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
            font-weight: 700;
            padding: 12px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
            color: white;
        }

        .alert-custom {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand navbar-light navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="homepage.php">
            <i class="fas fa-arrow-left mr-2"></i> BACK TO DASHBOARD
        </a>
        <ul class="navbar-nav ml-auto">
             <li class="nav-item">
                <span class="nav-link text-gray-600">
                    User: <b><?php echo $_SESSION['username']; ?></b>
                </span>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style="margin-top: 100px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show alert-custom shadow-sm mb-4" role="alert">
                    <?php if($message_type == 'success') echo '<i class="fas fa-check-circle mr-2"></i>'; ?>
                    <?php if($message_type == 'danger') echo '<i class="fas fa-exclamation-triangle mr-2"></i>'; ?>
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <i class="fas fa-car mr-2"></i> Add New Vehicle
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <form action="" name="carForm" method="post">
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="make">Car Make (Manufacturer)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="make" name="make" placeholder="e.g. Toyota, Ford" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="model">Car Model</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-car-side"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="model" name="model" placeholder="e.g. Camry, Ranger" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="year">Year of Manufacture</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="year" name="year" placeholder="e.g. 2024" min="1900" max="2100" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="color">Color</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-palette"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="color" name="color" placeholder="e.g. White, Black" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity to Add</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" min="1" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price">Price (USD)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button type="submit" name="insert" class="btn btn-submit btn-block">
                            <i class="fas fa-plus-circle mr-2"></i> ADD TO INVENTORY
                        </button>
                        
                    </form>
                </div>
                <div class="card-footer text-center bg-light text-muted small">
                    Note: If the exact car (Make, Model, Year, Color) exists, quantity will be updated.
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