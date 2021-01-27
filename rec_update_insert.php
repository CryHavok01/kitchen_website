<?php
    include_once 'dbh.php';
    
    //check for errors including redundant name, missing fields
    $error = FALSE;
    $recipeId = $_POST['recipe_num'];
    $checkNameSql = "SELECT * FROM recipe_names WHERE NOT recipe_id = '$recipeId';";
    $result = mysqli_query($connection, $checkNameSql);
    $row = mysqli_fetch_assoc($result);
    $checkName = ucfirst(strtolower($_POST['recipe_name']));
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['recipe_name'] === $checkName){
            $error = TRUE;
            header("location: recipe_update.php?recipe_id=" . $recipeId . "&error=copy");
        };
    };
    
    if ($checkName === ""){
        $error = TRUE;
        header("location: recipe_update.php?recipe_id=" . $recipeId . "&error=missing");
    };
    
    $curIng = 1;
    $ingName = 'i' . $curIng . '-name';
    $ingQuant = 'i' . $curIng . '-quant';
    $ingUnit = 'i' . $curIng . '-units';
    $ingOther = 'i' . $curIng . '-other';
    
    while (array_key_exists($ingName, $_POST) || array_key_exists($ingQuant, $_POST) || array_key_exists($ingUnit, $_POST) || array_key_exists($ingOther, $_POST)) {
        if ($_POST[$ingName] === "" || $_POST[$ingQuant] === "" || !array_key_exists($ingUnit, $_POST)){
            $error = TRUE;
            header("location: recipe_update.php?recipe_id=" . $recipeId . "&error=missing");
        }
        if (array_key_exists($ingUnit, $_POST) && $_POST[$ingUnit] === "other"){
            if ($_POST[$ingOther] === ""){
                $error = TRUE;
                header("location: recipe_update.php?recipe_id=" . $recipeId . "&error=missing");
            }
        }
        $curIng ++;
        $ingName = 'i' . $curIng . '-name';
        $ingQuant = 'i' . $curIng . '-quant';
        $ingUnit = 'i' . $curIng . '-units';
        $ingOther = 'i' . $curIng . '-other';
    }
    
    $curStep = 1;
    $step = "step" . $curStep;
    while (array_key_exists($step, $_POST)){
        if ($_POST[$step] === ""){
            $error = TRUE;
            header("location: recipe_update.php?recipe_id=" . $recipeId . "&error=missing");
        }
        $curStep++;
        $step = "step" . $curStep;
    };

    if ($error === FALSE) {
    //update recipe_names
    $stmt = $connection->prepare("UPDATE recipe_names SET recipe_name=?, recipe_score=0 WHERE recipe_id=?;");
    $stmt->bind_param("si", $name, $recipeId);
    $name = ucfirst(strtolower($_POST['recipe_name']));
    $stmt->execute();
    $stmt->close();
    
    $curIng = 1;
    
    //update ingredients
    $stmt = $connection->prepare("UPDATE recipe_ingredients SET ingredient_name=?, ingredient_quantity=?, ingredient_units=? WHERE id=?;");
    $stmt->bind_param("sdsi", $newName, $newQuant, $newUnit, $newId);
    $ingName = 'i' . $curIng . '-name';
    $ingQuant = 'i' . $curIng . '-quant';
    $ingUnit = 'i' . $curIng . '-units';
    $ingOther = 'i' . $curIng . '-other';
    $ingId = 'i' . $curIng . '-id';
    $newId = $_POST[$ingId];
    $newName = ucfirst(strtolower($_POST[$ingName]));
    $newQuant = $_POST[$ingQuant];
    if ($_POST[$ingUnit] === "other") {
        $newUnit = ucfirst(strtolower($_POST[$ingOther]));
    } else {
        $newUnit = $_POST[$ingUnit];
    };

    while (array_key_exists($ingId, $_POST)) {
        $stmt->execute();
        $curIng ++;
        $ingName = 'i' . $curIng . '-name';
        $ingQuant = 'i' . $curIng . '-quant';
        $ingUnit = 'i' . $curIng . '-units';
        $ingId = 'i' . $curIng . '-id';
        $ingOther = 'i' . $curIng . '-other';
        if (array_key_exists($ingId, $_POST)) {
            $newName = ucfirst(strtolower($_POST[$ingName]));
            $newQuant = $_POST[$ingQuant];
            $newId = $_POST[$ingId];
            if ($_POST[$ingUnit] == "other") {
                $newUnit = ucfirst(strtolower($_POST[$ingOther]));
            } else {
                $newUnit = $_POST[$ingUnit];
            }
        }
    };
    $stmt->close();

    //add new ingredients
    $stmt = $connection->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_name, ingredient_quantity, ingredient_units) VALUES ('$recipeId', ?, ?, ?);");
    $stmt->bind_param("sds", $newName, $newQuant, $newUnit);
    if (array_key_exists($ingName, $_POST)) {
        $newName = ucfirst(strtolower($_POST[$ingName]));
        $newQuant = $_POST[$ingQuant];
        if ($_POST[$ingUnit] === "other") {
            $newUnit = ucfirst(strtolower($_POST[$ingOther]));
        } else {
            $newUnit = $_POST[$ingUnit];
        };
    };    
    while (array_key_exists($ingName, $_POST)) {
        $stmt->execute();
        $curIng ++;
        $ingName = 'i' . $curIng . '-name';
        $ingQuant = 'i' . $curIng . '-quant';
        $ingUnit = 'i' . $curIng . '-units';
        $ingOther = 'i' . $curIng . '-other';
        if (array_key_exists($ingName, $_POST)) {
            $newName = ucfirst(strtolower($_POST[$ingName]));
            $newQuant = $_POST[$ingQuant];
            if ($_POST[$ingUnit] === "other") {
                $newUnit = ucfirst(strtolower($_POST[$ingOther]));
            } else {
                $newUnit = $_POST[$ingUnit];
            }
        }
    };
    $stmt->close();
    
    //update steps
    $curStep = 1;
    $stmt = $connection->prepare("UPDATE recipe_steps SET step=? WHERE id=?;");
    $stmt->bind_param("si", $newStep, $newStepId);
    $step = 'step' . $curStep;
    $stepId = 'step' . $curStep . "-id";
    $newStep = $_POST[$step];
    $newStepId = $_POST[$stepId];
    
    while (array_key_exists($stepId, $_POST)) {
        $stmt->execute();
        $curStep ++;
        $step = 'step' . $curStep;
        $stepId = 'step' . $curStep . "-id";
        if (array_key_exists($stepId, $_POST)) {
            $newStep = $_POST[$step];
            $newStepId = $_POST[$stepId];
        }
    };
    $stmt->close();
    
    //insert new steps
    $stmt = $connection->prepare("INSERT INTO recipe_steps (recipe_id, step) VALUES ('$recipeId', ?);");
    $stmt->bind_param("s", $newStep);

    if (array_key_exists($step, $_POST)) {
        $newStep = $_POST[$step];
    };
    
    while (array_key_exists($step, $_POST)) {
        $stmt->execute();
        $curStep ++;
        $step = 'step' . $curStep;
        if (array_key_exists($step, $_POST)) {
            $newStep = $_POST[$step];
        }
    };
    $stmt->close();
    header("location: index.php");
    };
