<?php
include './database.php';
$id = $_POST['delete_id'];
$sql = "DELETE FROM product WHERE id ='$id'";
$sql1 = "SELECT * FROM product WHERE id = '$id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
unlink($row['images']);
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data deleted')</script>";
    header("location:index.php");
} else {
    echo '("Delete not succesfully")'
        . $conn->error;
}
