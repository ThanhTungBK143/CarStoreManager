


<?php
session_start();
include "connection.php";

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Xử lý xóa user
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id=$delete_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Xóa tài khoản thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi xóa tài khoản!";
    }
    header("Location: edituser.php");
    exit();
}

// Xử lý cập nhật thông tin user
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $sql = "UPDATE users SET username='$username', email='$email', phone='$phone' WHERE id=$user_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Cập nhật thông tin thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi cập nhật thông tin!";
    }
    header("Location: edituser.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý tài khoản</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Quản lý tài khoản người dùng</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users WHERE username != 'admin'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <form method="post" class="edit-form" style="display: none;">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control">
                        </td>
                        <td>
                                <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control">
                        </td>
                        <td>
                                <input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control">
                        </td>
                        <td>
                                <button type="submit" name="update" class="btn btn-success btn-sm">Save</button>
                                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
                            </form>
                            
                            <div class="view-mode">
                                <span class="username"><?php echo $row['username']; ?></span>
                                <span class="email"><?php echo $row['email']; ?></span>
                                <span class="phone"><?php echo $row['phone']; ?></span>
                                <button class="btn btn-primary btn-sm edit-btn">Edit</button>
                                <a href="edituser.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var row = $(this).closest('tr');
                row.find('.edit-form').show();
                row.find('.view-mode').hide();
            });

            $('.cancel-edit').click(function() {
                var row = $(this).closest('tr');
                row.find('.edit-form').hide();
                row.find('.view-mode').show();
            });
        });
    </script>
</body>
</html>