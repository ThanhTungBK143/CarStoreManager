<?php
include "connection.php";
$product_id=$_GET["id"];
mysqli_query($link,"delete from cars where product_id=$product_id");
//header("location.index.php");
?>

<script type="text/javascript">
 window.location="homepage.php";
    </script>



