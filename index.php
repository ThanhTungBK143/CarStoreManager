<?php
include "connection.php";
<<<<<<< HEAD
session_start();

// --- XỬ LÝ SẮP XẾP ---
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$sql = "";

switch ($sort) {
    case 'price_asc': $sql = "SELECT * FROM cars ORDER BY price ASC"; break;
    case 'price_desc': $sql = "SELECT * FROM cars ORDER BY price DESC"; break;
    case 'bestseller':
        $sql = "SELECT c.*, COALESCE(SUM(st.quantity), 0) as total_sold FROM cars c LEFT JOIN sales_transactions st ON c.product_id = st.product_id GROUP BY c.product_id ORDER BY total_sold DESC";
        break;
    default: $sql = "SELECT * FROM cars ORDER BY product_id DESC"; break;
}
$result = mysqli_query($link, $sql);
=======
include "auth_check.php";
$username = htmlspecialchars($_SESSION['username']);
$role = isset($_SESSION['role']) ? strtolower($_SESSION['role']) : 'sale'; 

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
>>>>>>> 2f950b2472c9ec3301f744f4c6ba2e60762a49c8
?>

<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
    <title>Welcome to SkynetAuto</title>
=======
    <title>Dashboard - Quản Lý</title>
>>>>>>> 2f950b2472c9ec3301f744f4c6ba2e60762a49c8
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
<<<<<<< HEAD

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fc; }
        .navbar-public { background-color: #0a0e27; box-shadow: 0 2px 15px rgba(0,0,0,0.1); padding: 15px 0; }
        .navbar-brand { font-size: 1.8rem; font-weight: 800; color: #fff !important; letter-spacing: 1px; }
        .navbar-brand span { color: #4e73df; }
        .btn-manager { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 8px 20px; border-radius: 50px; transition: all 0.3s; font-weight: 600; }
        .btn-manager:hover { background: #4e73df; color: white; border-color: #4e73df; text-decoration: none; transform: translateY(-2px); }
        .hero-section { background: linear-gradient(rgba(10, 14, 39, 0.8), rgba(10, 14, 39, 0.8)), url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); background-size: cover; background-position: center; color: white; padding: 100px 0; text-align: center; margin-bottom: 50px; }
        .hero-title { font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; }
        .hero-subtitle { font-size: 1.2rem; opacity: 0.8; max-width: 600px; margin: 0 auto; }
        .filter-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; }
        .form-select { border: 1px solid #e3e6f0; border-radius: 50px; padding: 10px 20px; outline: none; min-width: 200px; color: #5a5c69; font-weight: bold; }
        
        .car-card { border: none; border-radius: 15px; overflow: hidden; background: white; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); transition: all 0.3s; height: 100%; }
        .car-card:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.15); }
        .car-img-top { height: 200px; object-fit: cover; width: 100%; }
        .card-body { padding: 25px; }
        .car-price { color: #4e73df; font-size: 1.5rem; font-weight: 800; margin-top: 10px; display: block; }
        .badge-stock { background-color: #e3f2fd; color: #4e73df; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
        .badge-out { background-color: #ffeaea; color: #e74a3b; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }

        /* HOTLINE BUTTON CSS */
        .hotline-btn { position: fixed; bottom: 30px; right: 30px; z-index: 9999; background: linear-gradient(45deg, #25d366, #128c7e); color: white !important; border-radius: 50px; height: 60px; width: 60px; display: flex; align-items: center; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4); text-decoration: none !important; }
        .hotline-icon { width: 60px; height: 60px; min-width: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; animation: phone-shake 1.5s infinite; }
        .hotline-number { white-space: nowrap; opacity: 0; max-width: 0; transition: all 0.4s ease; font-weight: 800; font-size: 1.1rem; }
        .hotline-btn:hover { width: 300px; background: linear-gradient(45deg, #128c7e, #075e54); }
        .hotline-btn:hover .hotline-number { opacity: 1; max-width: 250px; padding-right: 25px; }
        .hotline-btn:hover .hotline-icon { animation: none; }
        @keyframes phone-shake { 0% { transform: rotate(0) scale(1) skew(1deg) } 10% { transform: rotate(-25deg) scale(1) skew(1deg) } 20% { transform: rotate(25deg) scale(1) skew(1deg) } 30% { transform: rotate(-25deg) scale(1) skew(1deg) } 40% { transform: rotate(25deg) scale(1) skew(1deg) } 50% { transform: rotate(0) scale(1) skew(1deg) } 100% { transform: rotate(0) scale(1) skew(1deg) } }
=======
    <style>
        body { background-color: #f8f9fc; font-family: 'Nunito', sans-serif; color: #5a5c69; }
        .navbar-custom { background-color: #ffffff; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); }
        .navbar-brand { font-weight: 800; color: #4e73df !important; letter-spacing: 1px; }
        .nav-link { color: #858796 !important; font-weight: 600; }
        .welcome-card { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 15px; padding: 30px; margin-bottom: 40px; box-shadow: 0 4px 20px rgba(78, 115, 223, 0.4); }
        .role-badge { background-color: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; }
        .dashboard-card { border: none; border-radius: 15px; background-color: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); transition: all 0.3s ease-in-out; height: 100%; text-decoration: none !important; display: block; overflow: hidden; }
        .dashboard-card:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(58,59,69,.15); }
        .card-body { padding: 30px; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 200px; }
        .icon-circle { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 20px; transition: transform 0.3s; }
        .dashboard-card:hover .icon-circle { transform: scale(1.1); }
        .card-title { font-weight: 800; font-size: 1.1rem; text-transform: uppercase; margin: 0; color: #5a5c69; }
        .card-car .icon-circle { background-color: #e3f2fd; color: #4e73df; }
        .card-car:hover .card-title { color: #4e73df; }
        .card-customer .icon-circle { background-color: #fff3cd; color: #f6c23e; }
        .card-customer:hover .card-title { color: #f6c23e; }
        .card-employee .icon-circle { background-color: #d4edda; color: #1cc88a; }
        .card-employee:hover .card-title { color: #1cc88a; }
        .card-trans .icon-circle { background-color: #f8d7da; color: #e74a3b; }
        .card-trans:hover .card-title { color: #e74a3b; }
>>>>>>> 2f950b2472c9ec3301f744f4c6ba2e60762a49c8
    </style>
</head>
<body>

<<<<<<< HEAD
<nav class="navbar navbar-public fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="index.php">Skynet<span>Auto</span></a>
        <a href="login.php" class="btn-manager"><i class="fas fa-user-shield mr-2"></i> CarManager Login</a>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <h1 class="hero-title">Find Your Dream Car</h1>
        <p class="hero-subtitle">Premium selection of vehicles. Quality assured. Best prices in the market.</p>
    </div>
</div>

<div class="container">
    <div class="filter-box">
        <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-th-large mr-2"></i> Available Inventory</h5>
        <form action="" method="get" id="sortForm">
            <div class="d-flex align-items-center">
                <span class="mr-3 font-weight-bold text-muted">Sort By:</span>
                <select name="sort" class="form-select" onchange="document.getElementById('sortForm').submit()">
                    <option value="newest" <?php if($sort == 'newest') echo 'selected'; ?>>Newest Arrivals</option>
                    <option value="price_asc" <?php if($sort == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php if($sort == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                    <option value="bestseller" <?php if($sort == 'bestseller') echo 'selected'; ?>>🔥 Best Selling</option>
                </select>
            </div>
        </form>
    </div>

    <div class="row">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $make = htmlspecialchars($row['make']);
                $model = htmlspecialchars($row['model']);
                $year = $row['year'];
                $color = htmlspecialchars($row['color']);
                $price = number_format($row['price'], 2);
                $qty = $row['quantity'];
                
                // --- XỬ LÝ ẢNH LOCAL ---
                // Mặc định là ảnh giữ chỗ nếu chưa có ảnh
                $img_src = "https://via.placeholder.com/600x400.png?text=No+Image"; 
                
                // Nếu cột image có dữ liệu và file tồn tại trên server
                if (!empty($row['image'])) {
                    $local_path = "./uploads/" . $row['image'];
                    if (file_exists($local_path)) {
                        $img_src = $local_path;
                    }
                }

                echo '<div class="col-lg-4 col-md-6 mb-4">';
                echo '  <div class="car-card">';
                echo '      <div style="height:200px; overflow:hidden; background:#eee;">';
                echo '          <img src="'.$img_src.'" class="car-img-top" alt="'.$make.'">';
                echo '      </div>';
                echo '      <div class="card-body">';
                echo '          <div class="d-flex justify-content-between align-items-start">';
                echo '              <h4 class="font-weight-bold text-dark mb-1">'.$make.' '.$model.'</h4>';
                echo '              <span class="badge badge-secondary">'.$year.'</span>';
                echo '          </div>';
                echo '          <p class="text-muted small mb-3"><i class="fas fa-palette mr-1"></i> Color: '.$color.'</p>';
                echo '          <div class="d-flex justify-content-between align-items-center mt-4">';
                echo '              <span class="car-price">$'.$price.'</span>';
                if ($qty > 0) {
                    echo '          <span class="badge-stock"><i class="fas fa-check-circle mr-1"></i> In Stock: '.$qty.'</span>';
                } else {
                    echo '          <span class="badge-out"><i class="fas fa-times-circle mr-1"></i> Sold Out</span>';
                }
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h3 class="text-muted">No cars available.</h3></div>';
        }
        ?>
    </div>
</div>

<a href="tel:0988000999" class="hotline-btn">
    <div class="hotline-icon"><i class="fas fa-phone-alt"></i></div>
    <span class="hotline-number">Hotline: 0988.000.999</span>
</a>

<footer>
    <div class="container text-center py-4 text-white">
        <h4 class="font-weight-bold">SkynetAuto</h4>
        <p class="small opacity-50">© 2025 SkynetAuto Corporation.</p>
    </div>
</footer>
=======
<nav class="navbar navbar-expand navbar-light navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-laugh-wink"></i> CAR MANAGER
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hello, <b><?php echo $username; ?></b></span>
                    <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=<?php echo $username; ?>&background=4e73df&color=fff" width="30">
                </span>
            </li>

            <li class="nav-item ml-3">
                <a class="nav-link text-primary" href="index.php" title="Go to Public Website">
                    <i class="fas fa-home fa-sm fa-fw mr-2"></i> Website
                </a>
            </li>

            <li class="nav-item ml-3">
                <a class="nav-link text-danger" href="index.php?logout=true" onclick="return confirm('Ready to Leave?');">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <div class="welcome-card text-center text-md-left d-md-flex justify-content-between align-items-center">
                <div>
                    <h2 class="font-weight-bold mb-2">Welcome Back, <?php echo $username; ?>!</h2>
                    <p class="mb-0 op-8">Here is your management dashboard overview.</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <span class="role-badge">
                        <i class="fas fa-user-tag mr-2"></i> <?php echo strtoupper($role); ?> ACCOUNT
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="car.php" class="dashboard-card card-car">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-car"></i></div>
                    <h5 class="card-title">Cars Inventory</h5>
                    <small class="text-muted mt-2">Manage stocks & prices</small>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="customer.php" class="dashboard-card card-customer">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-users"></i></div>
                    <h5 class="card-title">Customers</h5>
                    <small class="text-muted mt-2">View client list</small>
                </div>
            </a>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="transactions.php" class="dashboard-card card-trans">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h5 class="card-title">Transactions</h5>
                    <small class="text-muted mt-2">View sales history</small>
                </div>
            </a>
        </div>

        <?php if ($role === 'admin'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="employee.php" class="dashboard-card card-employee">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-user-tie"></i></div>
                    <h5 class="card-title">Employees</h5>
                    <small class="text-muted mt-2">Manage staff access</small>
                </div>
            </a>
        </div>
        <?php endif; ?>

    </div>
</div>

>>>>>>> 2f950b2472c9ec3301f744f4c6ba2e60762a49c8
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>