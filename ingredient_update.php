<?php
    include_once 'dbh.php';
    
    $error = FALSE;
    $idNum = $_POST['spice_num'];
    $checkNameSql = "SELECT * FROM spices WHERE NOT spice_num = '$idNum';";
    $result = mysqli_query($connection, $checkNameSql);
    $row = mysqli_fetch_assoc($result);
    $checkName = ucfirst(strtolower($_POST['spice_name']));
    $nameSql = "SELECT * FROM spices WHERE spice_num = '$idNum';";
    $nameResult = mysqli_query($connection, $nameSql);
    $nameRow = mysqli_fetch_assoc($nameResult);
    $name = $nameRow['spice_name'];
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['spice_name'] === $checkName){
            $error = TRUE;
            header("location: ingredient.php?ingredient=" . $name . "&error=copy");
        };
    };

    
    if ($_POST['spice_name'] === "" || $_POST['spice_quant'] === "" || !array_key_exists('spice_units', $_POST)){
        $error = TRUE;
        header("location: ingredient.php?ingredient=" . $name . "&error=missing");
    }
    if (array_key_exists('spice_units', $_POST) && $_POST['spice_units'] === "other"){
        if ($_POST['other_units'] === ""){
            $error = TRUE;
            header("location: ingredient.php?ingredient=" . $name . "&error=missing");
        }
    }
    
    
    if ($error === FALSE){
    $stmt = $connection->prepare("UPDATE spices SET spice_name=?, spice_quant=?, spice_units=? WHERE spice_num=?;");
    $stmt->bind_param("sdsi", $name, $quant, $units, $idNum);
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
    };
