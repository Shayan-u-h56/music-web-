<?php include('connection.php');
$login = false;
$error = "";
if (isset($_POST['sigin'])) {
    $name = $_POST['uname'];
    $email = $_POST['uemail'];
    $password = $_POST['upass'];
    $role_id = 1;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $checkemail = "SELECT * FROM userdetails WHERE u_email='$email'";
    $checkquery = mysqli_query($conn, $checkemail);
    if (mysqli_num_rows($checkquery) > 0) {
        $error= 'user already esist';
    } else {
        // $sql = "INSERT INTO userdetails(u_name,u_email,u_pass) VALUES ('$name','$email','$hash')";
        // $result = mysqli_query($conn, $sql);
        $sql = $conn->prepare("INSERT INTO userdetails(u_name,u_email,u_pass,rol_id) VALUES (?,?,?,?)");
        $sql->bind_param("sssi", $name, $email, $hash, $role_id);
        $sql->execute();
        // $result = $sql->get_result();
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['loginemail'];
    $pass = $_POST['loginpass'];
    // $verifyemail = "SELECT * FROM userdetails WHERE u_email='$email'";
    // $verify = mysqli_query($conn, $verifyemail);
    $verifyemail = $conn->prepare("SELECT * FROM userdetails WHERE u_email=?");
    $verifyemail->bind_param("s", $email);
    $verifyemail->execute();
    $verify = $verifyemail->get_result();
    if (mysqli_num_rows($verify) > 0) {
        $userdata = mysqli_fetch_assoc($verify);
        $userrole = $userdata['rol_id'];
        $verifypass = password_verify($pass, $userdata['u_pass']);
        if ($verifypass) {
            session_start();
            $_SESSION['loginedin'] = true;

            $_SESSION['loginemail'] = $email;
            $_SESSION['user_id'] = $userdata['id'];
            $_SESSION['rol_id'] = $userdata['rol_id'];
            if ($userrole == 1) {
                header("location: index.php");
                exit();
            } else if ($userrole == 2) {
                header("location: admin.php");
                exit();
            }
        } else {
            $error ="incorrect passwprd";
        }
    } else {
        $error ="user dosnot exist sigin first";
    }
}
?>;
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/utility.css">

    <title>Modern Login Page | AsmrProg</title>
</head>

<body>


    <?php if (!empty($error)) { ?>
        <div class="alert">
            <?php echo $error; ?>
        </div>
    <?php } ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registeration</span>
                <input name="uname" type="text" placeholder="Name" required>
                <input name="uemail" type="email" placeholder="Email" required>
                <input name="upass" type="password" placeholder="Password" required>
                <button type="submit" name="sigin">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <input name="loginemail" type="email" placeholder="Email" required>
                <input name="loginpass" type="password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>