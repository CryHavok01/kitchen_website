<?php
    include_once 'dbh.php';
    
    $checkNameSql = "SELECT * FROM spices;";
    $result = mysqli_query($connection, $checkNameSql);
    $row = mysqli_fetch_assoc($result);
    $checkName = ucfirst(strtolower($_POST['spice_name']));
    $error = FALSE;
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['spice_name'] === $checkName){
            $error = TRUE;
            header("location: addspice.php?error=copy");
        };
    };
    if ($_POST['spice_name'] === "" || $_POST['spice_quant'] === "" || !array_key_exists('spice_units', $_POST)){
        $error = TRUE;
        header("location: addspice.php?error=missing");
    }
    if ($_POST['spice_units'] === "other" && $_POST['other_units'] === ""){
        $error = TRUE;
        header("location: addspice.php?error=missing");
    }
    
    if ($error === FALSE){
    $stmt = $connection->prepare("INSERT INTO spices (spice_name, spice_quant, spice_units) VALUES (?, ?, ?);");
    $stmt->bind_param("sds", $name, $quant, $units);
    $name = ucfirst(strtolower($_POST['spice_name']));
    $quant = $_POST['spice_quant'];
    if ($_POST['spice_units'] == 'other'){
        $units = ucfirst(strtolower($_POST['other_units']));
    } else {
        $units = $_POST['spice_units'];
    };
    $stmt->execute();
    $stmt->close();
    header("location: index.php");
    }
