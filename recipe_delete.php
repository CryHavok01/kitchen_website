<?php
include_once 'dbh.php';
$stmt = $connection->prepare("DELETE FROM recipe_names WHERE recipe_id=?;");
$stmt->bind_param("i", $idNum);
$idNum = $_POST['recipe_id'];
$stmt->execute();
$stmt->close();
$stmt = $connection->prepare("DELETE FROM recipe_ingredients WHERE recipe_id=?;");
$stmt->bind_param("i", $idNum);
$idNum = $_POST['recipe_id'];
$stmt->execute();
$stmt->close();
$stmt = $connection->prepare("DELETE FROM recipe_steps WHERE recipe_id=?;");
$stmt->bind_param("i", $idNum);
$idNum = $_POST['recipe_id'];
$stmt->execute();
$stmt->close();
header("location: index.html");
?>
