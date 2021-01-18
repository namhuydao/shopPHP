<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./signIn.css">
  <title>Document</title>
</head>

<body>
  <?php include './database.php' ?>
  <?php include './function.php' ?>
  <?php
  $nameErr = $emailErr = $passwordErr = $confirmErr = "";
  $name = $email = $password = $confirm = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Name is required";
    } else {
      $name = test_input($_POST["name"]);
    }
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email format";
        $email = "";
      }
      $sql = mysqli_query($conn, "SELECT * FROM users where email='$email'");
      if (mysqli_num_rows($sql) > 0) {
        $emailErr = "Email already exists";
        $email = "";
      }
    }
    if (empty($_POST["password"])) {
      $passwordErr = "Password is required";
    } else {
      $password = test_input($_POST["password"]);
      if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
        $passwordErr = "Must be a minimum of 8 characters,
                        Must contain at least 1 number,
                        Must contain at least one uppercase character,
                        Must contain at least one lowercase character";
        $password = "";
      }
    }
    if (empty($_POST["confPassword"])) {
      $confirmErr = "Confirm Password is required";
    } else {
      $confirm = test_input($_POST["confPassword"]);
    }
    if ($password !== $confirm) {
      $confirmErr = "Password not match";
      $confirm = "";
    }
    if ($name != "" && $password != "" && $email != "" && $confirm != "") {
      $md5Password = md5($password);
      $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$md5Password')";
      if ($conn->query($sql) === true) {
        echo "<script>alert('Sign Up successfully!')</script>";
        header("Location: signIn.php");
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
  $conn->close();
  ?>
  <div class="sidenav">
    <div class="login-main-text">
      <h2>Application<br> Register Page</h2>
    </div>
  </div>
  <div class="main">
    <div class="col-md-6 col-sm-12">
      <form action="" method="POST">
        <div class="login-form">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
            <span class="error"><?php echo $nameErr; ?></span>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email">
            <span class="error"><?php echo $emailErr; ?></span>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="error"><?php echo $passwordErr; ?></span>
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confPassword" class="form-control" placeholder="Confirm Password">
            <span class="error"><?php echo $confirmErr; ?></span>
          </div>
          <button class="btn btn-black">Register</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>