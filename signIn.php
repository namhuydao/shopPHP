<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location:index.php');
}
if (isset($_POST["login"])) {
    include './database.php';
    include './function.php';
    $email = test_input($_POST["email"]);
    $password = md5(test_input($_POST["password"]));
    $sql = "SELECT * FROM users where email='$email' and password='$password'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        //  lấy bản ghi tài khoản trong database
        $user = $query->fetch_assoc();

        //  lưu tài khỏan vào session để nhớ
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email']
        ];
        if (isset($_POST['remember_me'])) {
            setcookie('email', $email, time() + (3600 * 24 * 30));
            setcookie('password', $_POST["password"], time() + (3600 * 24 * 30));
        }
        header("Location: index.php");
    } else {
        echo "<script>alert('Invalid Email ID/Password')</script>";
    }
} else {
    $email = '';
    $password = '';
    if (isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="signIn.css">
    <title>Document</title>
</head>

<body>
    <div class="sidenav">
        <div class="login-main-text">
            <h2>Application<br> Login Page</h2>
            <p>Login or register from here to access.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <form action="" method="POST">
                <div class="login-form">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
                    </div>
                    <div class="row align-items-center remember">

                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me" value="1">Remember Me
                    </div>
                    <button name="login" class="btn btn-black">Login</button>
                    <a href="signUp.php" class="btn btn-secondary">Register</a>
                    <a href="forgot.php" style="color: black !important;">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>