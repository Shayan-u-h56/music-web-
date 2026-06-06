<?php
session_start();
include("connection.php");
if ($_SESSION['rol_id'] != 2) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * from userdetails where u_name like '%$search%'";
} else {
    $sql = "SELECT * FROM userdetails";
}
$result = mysqli_query($conn, $sql);
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "update") {
        echo "<div class='alert alert-success'>User Update Succssfully</div>";
    };

    if ($_GET['msg'] == "delete") {
        echo "<div class='alert alert-danger'>User delete Succssfully</div>";
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
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Title</title>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control" name="search" type="search " placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success me-4 px-4" type="submit">Search</button>
                    <a href="add.php" class="btn btn-outline-success me-4 px-4" type="submit">+ADD</a>
                    <ul>

                        <?php if (isset($_SESSION['loginedin'])) { ?>

                            <li>
                                <?php echo $_SESSION['loginemail']; ?>
                            </li>

                            <li>
                                <a href="logout.php">Logout</a>
                            </li>

                        <?php }  ?>



                    </ul>

                </form>
            </div>
        </div>
    </nav>
    <h1 class="text-center">admin panel</h1>

    <table class="table ">
        <thead>
            <tr>
                <th>id</th>
                <th>role id</th>
                <th>name</th>
                <th>email</th>
                <th>created_at</th>
                <th>update_at</th>
                <th>UPDATE & DELETE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['rol_id'] ?></td>
                    <td><?php echo $row['u_name'] ?></td>
                    <td><?php echo $row['u_email'] ?></td>
                    <td><?php echo $row['created_at'] ?></td>
                    <td><?php echo $row['update_at'] ?></td>


                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning p-1">UPDATE</a>
                        <?php
                        if ($_SESSION['user_id'] != $row['id']) { ?>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger p-1" onclick="return confirm('Are You Sure?')">DELETE</a>
                        <?php } ?>
                    </td>

                </tr>


            <?php } ?>



        </tbody>
    </table>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>

</html>