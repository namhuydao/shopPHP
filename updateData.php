<?php include './database.php' ?>
<?php include './function.php' ?>
<?php
$id = $_POST['update_id'];
$name = $_POST["name"];
$description = $_POST["description"];
$content = $_POST["content"];
$file_type = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
$file_size = $_FILES['fileToUpload']['size'];
$file_tem_loc = $_FILES['fileToUpload']['tmp_name'];
$uploadOk = 1;
if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
    $file_name = uniqid() . "." . pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
    $file_store = "upload/" . $file_name;
    if (($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
        && $file_type != "gif")) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location = 'index.php';</script>";
        $uploadOk = 0;
    }
    if ($file_size > 500000) {
        echo "<script>alert('Sorry, your file is too large.'); window.location = 'index.php';</script>";
        $uploadOk = 0;
    } else {
        $sql1 = "SELECT * FROM product WHERE id = '$id'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
        unlink($row['images']);
    }
}
if (!is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
    $update = "UPDATE product SET name='$name', description='$description', content='$content'  WHERE id='$id'";
    if ($conn->query($update) === true) {
        echo "<script>alert('Data updated'); window.location = 'index.php';</script> ";
    } else {
        echo "<script>alert('Data not updated')</script>";
    }
    die;
}
if ($uploadOk != 0) {
    move_uploaded_file($file_tem_loc, $file_store);
    $update = "UPDATE product SET name='$name', description='$description', content='$content', images = '$file_store'  WHERE id='$id'";

    if ($conn->query($update) === true) {
        echo "<script>alert('Data updated'); window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('Data not updated')</script>";
    }
}

