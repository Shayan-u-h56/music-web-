<?php
include("connection.php");
if (isset($_POST['btnadd'])) {
    $name = $_POST['uname'];
    $email = $_POST['uemail'];
    $password = $_POST['upass'];
    $role_id = 1;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $checkemail = "SELECT * FROM userdetails WHERE u_email='$email'";
    $checkquery = mysqli_query($conn, $checkemail);
    if (mysqli_num_rows($checkquery) > 0) {
        echo 'user already esist';
    } else {
        // $sql = "INSERT INTO userdetails(u_name,u_email,u_pass) VALUES ('$name','$email','$hash')";
        // $result = mysqli_query($conn, $sql);
        $sql = $conn->prepare("INSERT INTO userdetails(u_name,u_email,u_pass,rol_id) VALUES (?,?,?,?)");
        $sql->bind_param("sssi", $name, $email, $hash, $role_id);
        if ($sql->execute()) {
            // Srf data successfully insert hone par hi admin.php par bhejein
            header("location: admin.php");
            exit(); 
        } else {
            $error_msg = "Database Error: Data insert nahi ho saka. " . $conn->error;
        }
        // $result = $sql->get_result();
    }
   
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Title</title>
</head>

<body>
    <h1>add user</h1>
    <form action="" method="post">

        <input name="uname" type="text" placeholder="Name" required>
        <input name="uemail" type="email" placeholder="Email" required>
        <input name="upass" type="password" placeholder="Password" required>
        <button type="submit" name="btnadd">add</button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>

</html>