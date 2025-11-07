<?php
include "connection.php";
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
    <button name="Edit" class="btn btn-default">Edit</button>
    <button name="update" class="btn btn-default">Update</button>
    <button name="delete" class="btn btn-default">Delete</button>
<!-- new column inserted for records -->
<!-- Search for boostrap table template online and copy code -->
<div class="col-lg-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Company</th>
            <th>Model</th>
            <th>Year</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <!-- Database connection -->
        <?php
        if (!empty($link)) {
            $res=mysqli_query($link,"select * from cars");
        }
        while($row=mysqli_fetch_array($res))
        {
            echo "<tr>";
            echo "<td>"; echo $row["product_id"]; echo "</td>";
            echo "<td>"; echo $row["make"]; echo "</td>";
            echo "<td>"; echo $row["model"]; echo "</td>";
            echo "<td>"; echo $row["year"]; echo "</td>";
            echo "<td>"; echo $row["color"]; echo "</td>";
            echo "<td>"; echo $row["quantity"]; echo "</td>";
            echo "<td>"; echo $row["price"]; echo "</td>";
echo "<td>
        <a href='delete.php?id={$row['product_id']}'>
          <button type='button' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this car?');\">Delete</button>
        </a>
      </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div class="col-lg-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Edit</th>
            <th>Delete</th>
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
            echo "<td>"; echo $row["firstname"]; echo "</td>";
            echo "<td>"; echo $row["lastname"]; echo "</td>";
            echo "<td>"; echo $row["email"]; echo "</td>";
            echo "<td>"; echo $row["contact"]; echo "</td>";
            echo "<td>"; ?> <a href="edit.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-success">Edit </button></a> <?php echo "</td>";
echo "<td>
        <a href='delete.php?id={$row['id']}'>
          <button type='button' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this employee?');\">Delete</button>
        </a>
      </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>


<!-- new records insertion into database table -->
<!-- records delete from database table -->
<!-- records update from database table -->

<!-- to automatically refresh the pages after crud activity   window.location.href=window.location.href; -->
<?php
if(isset($_POST["insert"]))
{
    mysqli_query($link,"insert into table1 values (NULL,'$_POST[firstname]' ,'$_POST[lastname]','$_POST[email]','$_POST[contact]')");
   ?>
    <script type="text/javascript">
    window.location.href=window.location.href;
    </script>
    <?php

}

if(isset($_POST["delete"]))
{
    mysqli_query($link,"delete from table1 where firstname='$_POST[firstname]'");
    ?>
    <script type="text/javascript">
        window.location.href=window.location.href;
    </script>
    <?php
}

if(isset($_POST["update"]))
{
    mysqli_query($link,"update table1 set firstname='$_POST[lastname]'where firstname='$_POST[firstname]'");
    ?>
    <script type="text/javascript">
        window.location.href=window.location.href;
    </script>
    <?php
}
?>
</html>