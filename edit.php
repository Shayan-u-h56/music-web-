<?php
include("connection.php");

$formid = $_GET['id'];
$sql = $conn->prepare("SELECT * FROM userdetails where id =?");
$sql->bind_param("i", $formid);
$sql->execute();
// $run = mysqli_query($conn, $sql);
$run = $sql->get_result();
$row = $run->fetch_assoc();
if (isset($_POST['edit'])) {
    $name = $_POST['uname'];
    $email = $_POST['mail'];
    $role = $_POST['u_role'];
    $editqurey = $conn->prepare("UPDATE userdetails SET u_name = ? , u_email=?,rol_id=?,update_at=NOW() where id =?");
    $editqurey->bind_param("ssii", $name, $email, $role, $formid);
    $editqurey->execute();
    // $result = mysqli_query($conn, $editqurey);
    
    header("location: admin.php?section=users&msg=update");

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

<body class="mx-5">
    <form method="post">

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Usernmae</label>
            <input type="text" value="<?php echo $row['u_name'] ?>" name="uname" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" value="<?php echo $row['u_email'] ?>" name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Role</label>
            <input type="number" value="<?php echo $row['rol_id'] ?>" name="u_role" class="form-control" id="exampleInputPassword1">
        </div>

        <button type="submit" class="btn btn-primary" name="edit">edit</button>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>

</html>