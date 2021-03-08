<?php
include_once 'dbh.php';
$stmt = $connection->prepare("DELETE FROM spices WHERE spice_num=?;");
$stmt->bind_param("i", $idNum);
$idNum = $_POST['spice_num'];
$stmt->execute();
$stmt->close();
header("location: index.html");
?>
