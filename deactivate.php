<?php include './database.php' ?>
<?php include './function.php' ?>
<?php
$id = $_GET['id'];
$sql = "UPDATE  product SET status = '0' WHERE id ='$id'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Product deactivated')</script>";
    header("location:index.php");
} else {
    echo '("Product not deactivated")';
}
