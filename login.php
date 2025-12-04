<?php
include "connection.php";
session_start();

$error_message = '';

if (isset($_SESSION['username'])) {
    header('location:homepage.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($link)) {
        $error_message = "Database connection error.";
    } else {
        $username = mysqli_real_escape_string($link, $_POST['username']);
        $password_input = $_POST['password'];
        $password_md5 = MD5($password_input); 

        $query = "SELECT id, username, role FROM users WHERE username=? AND password=?";
        $stmt = mysqli_prepare($link, $query);
        
        if ($stmt === false) {
             $error_message = "Database query error.";
        } else {
            mysqli_stmt_bind_param($stmt, 'ss', $username, $password_md5);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role']; 
                $_SESSION['user_id_from_db'] = $row['id']; 
                header('location: homepage.php');
                exit();
            } else {
                $error_message = "Incorrect username or password.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Car Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body, html {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            height: 100vh;
        }

        /* --- Cột bên trái: Hình ảnh --- */
        .bg-image {
            /* Hình nền xe hơi chất lượng cao từ Unsplash */
            background-image: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        /* Lớp phủ màu đen mờ để chữ dễ đọc hơn nếu muốn thêm chữ lên ảnh */
        .bg-image::before {
            content: "";
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
        }

        .caption-image {
            position: absolute;
            bottom: 50px;
            left: 50px;
            color: white;
            z-index: 2;
        }
        .caption-image h1 {
            font-weight: 800;
            font-size: 3rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }
        .caption-image p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* --- Cột bên phải: Form Login --- */
        .login-form-col {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }

        .brand-logo {
            font-size: 40px;
            color: #333;
            margin-bottom: 30px;
            font-weight: bold;
            letter-spacing: -1px;
        }
        .brand-logo span {
            color: #007bff; /* Màu xanh chủ đạo */
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #e1e1e1;
            border-radius: 0;
            padding: 25px 10px 10px 5px; /* Tạo không gian thoáng */
            background-color: transparent;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-bottom: 2px solid #007bff;
            background-color: #f9fcff;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-icon {
            position: absolute;
            right: 10px;
            top: 20px;
            color: #aaa;
        }

        .btn-custom {
            background: linear-gradient(to right, #0062E6, #33AEFF);
            border: none;
            color: white;
            padding: 15px;
            border-radius: 50px; /* Nút bo tròn hình viên thuốc */
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
            transition: transform 0.2s;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.6);
            color: white;
        }
        
        .alert-custom {
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container-fluid login-container">
    <div class="row no-gutters h-100">
        
        <div class="col-md-7 col-lg-8 d-none d-md-block bg-image">
            <div class="caption-image">
                <h1>Premium Cars.</h1>
                <p>Manage your inventory and sales with elegance.</p>
            </div>
        </div>

        <div class="col-md-5 col-lg-4 login-form-col">
            <div class="login-wrapper">
                
                <div class="text-center">
                    <div class="brand-logo">
                        <i class="fas fa-car-side"></i> Auto<span>Manager</span>
                    </div>
                    <h4 class="text-muted mb-4">Welcome Back!</h4>
                </div>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-custom shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <i class="fas fa-user form-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <i class="fas fa-lock form-icon"></i>
                    </div>

                    <button type="submit" class="btn btn-custom btn-block mt-5">
                        LOGIN
                    </button>
                    
                    <div class="text-center mt-4">
                        <small class="text-muted">Test Accounts: admin/12345 | sale1/pass123</small>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>