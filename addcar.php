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
    </form>
</div>


<?php
// INSERT
<?php
// INSERT HOẶC CỘNG DỒN
if(isset($_POST["insert"])) {
    // 1. Lấy dữ liệu và làm sạch (giống code của bạn)
    $make = mysqli_real_escape_string($link, $_POST['make']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $year = (int)$_POST['year'];
    $color = mysqli_real_escape_string($link, $_POST['color']);
    $quantity = (int)$_POST['quantity']; // Số lượng mới cần thêm
    $price = (float)$_POST['price'];     // Giá mới

    // 2. Kiểm tra xem xe đã tồn tại chưa
    // Xe được coi là trùng nếu CÙNG make, model, year, VÀ color
    $check_query = "SELECT * FROM Cars 
                    WHERE make='$make' AND model='$model' AND year='$year' AND color='$color'";
    $res = mysqli_query($link, $check_query);
    $num_rows = mysqli_num_rows($res);

    if($num_rows > 0) {
        // --- ĐÃ TỒN TẠI: Cập nhật (Cộng dồn số lượng) ---
        
        // Lấy số lượng cũ
        $row = mysqli_fetch_array($res);
        $old_quantity = $row["quantity"];
        
        // Tính số lượng mới
        $new_quantity = $old_quantity + $quantity;

        // Cập nhật lại dòng đó với số lượng mới và giá mới
        mysqli_query($link, "UPDATE Cars SET quantity='$new_quantity', price='$price' 
                            WHERE make='$make' AND model='$model' AND year='$year' AND color='$color'");

    } else {
        // --- CHƯA TỒN TẠI: Thêm mới như cũ ---
        mysqli_query($link,"INSERT INTO Cars (make, model, year, color, quantity, price) 
                            VALUES ('$make','$model','$year','$color','$quantity','$price')");
    }

    // Tải lại trang (giống code của bạn)
    echo "<script>window.location.href=window.location.href;</script>";
}

// DELETE (GIỮ NGUYÊN)
if(isset($_POST["delete"])) {
    $make = mysqli_real_escape_string($link, $_POST['make']);
    $model = mysqli_real_escape_string($link, $_POST['model']);

    // Xóa theo make + model để tránh xóa nhầm
    mysqli_query($link,"DELETE FROM Cars WHERE make='$make' AND model='$model'");
    echo "<script>window.location.href=window.location.href;</script>";
}

?>

?>
</body>
</html>
