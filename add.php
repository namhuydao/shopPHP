<?php
$name = $description = $content = "";

if (isset($_POST['add'])) {
    $name = test_input($_POST["name"]);
    $description = test_input($_POST["description"]);
    $content = test_input($_POST["content"]);
    $file_name = uniqid() . "." . pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);
    $file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tem_loc = $_FILES['fileToUpload']['tmp_name'];
    $file_store = "upload/" . $file_name;
    $uploadOk = 1;
    if (file_exists($file_store)) {
        echo "<script>alert('Sorry, file already exists.'); window.location = 'index.php';</script>";
        $uploadOk = 0;
    }
    if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
        && $file_type != "gif" ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location = 'index.php';</script>";
        $uploadOk = 0;
    }
    if ($file_size > 500000) {
        echo "<script>alert('Sorry, your file is too large.'); window.location = 'index.php';</script>";
        $uploadOk = 0;
    }
    if ($uploadOk != 0) {
        move_uploaded_file($file_tem_loc, $file_store);
        $sql = "INSERT INTO product (name, description, content, images) VALUES ('$name', '$description', '$content', '$file_store')";

        if ($conn->query($sql) === true) {
            echo "<script>alert('Data added'); window.location = 'index.php';</script>";
        } else {
            echo "<script>alert('Data not added')</script>";
        }
    }
}
?>