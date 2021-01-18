<?php
include './database.php';
$id = $_POST['delete_id'];
$sql = "DELETE FROM product WHERE id ='$id'";
unlink($_POST["name"]);
if ($conn->query($sql) === TRUE) {
  echo "<script>alert('Data deleted')</script>";
  header("location:index.php");
} else {
  echo '("Delete not succesfully")'
    . $conn->error;
}
