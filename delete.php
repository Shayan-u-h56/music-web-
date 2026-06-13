<?php
include("connection.php");
$formid=$_GET["id"];
$sql =$conn->prepare("DELETE FROM userdetails where id =?");
$sql->bind_param("i",$formid);
$sql->execute();
header("location: admin.php?section=users&msg=delete");
exit();
?>