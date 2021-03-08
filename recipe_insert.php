<?php
    include_once 'dbh.php';
    
    $checkNameSql = "SELECT * FROM recipe_names;";
    $result = mysqli_query($connection, $checkNameSql);
    $row = mysqli_fetch_assoc($result);
    $checkName = ucfirst(strtolower($_POST['recipe-name']));
    $error = FALSE;
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['recipe_name'] === $checkName){
            $error = TRUE;
            header("location: addrecipe.php?error=copy");
        };
    };
    if ($checkName === ""){
        $error = TRUE;
        header("location: addrecipe.php?error=missing");
    };
    
    $curIng = 1;
    $ingName = 'i' . $curIng . '-name';
    $ingQuant = 'i' . $curIng . '-quant';
    $ingUnit = 'i' . $curIng . '-unit';
    $ingOther = 'i' . $curIng . '-other';
    
    while (array_key_exists($ingName, $_POST) || array_key_exists($ingQuant, $_POST) || array_key_exists($ingUnit, $_POST) || array_key_exists($ingOther, $_POST)) {
        if ($_POST[$ingName] === "" || $_POST[$ingQuant] === "" || !array_key_exists($ingUnit, $_POST)){
            $error = TRUE;
            header("location: addrecipe.php?error=missing");
        }
        if (array_key_exists($ingUnit, $_POST) && $_POST[$ingUnit] === "other"){
            if ($_POST[$ingOther] === ""){
                $error = TRUE;
                header("location: addrecipe.php?error=missing");
            }
        }
        $curIng ++;
        $ingName = 'i' . $curIng . '-name';
        $ingQuant = 'i' . $curIng . '-quant';
        $ingUnit = 'i' . $curIng . '-unit';
        $ingOther = 'i' . $curIng . '-other';
    }
    
    $curStep = 1;
    $step = "step" . $curStep;
    while (array_key_exists($step, $_POST)){
        if ($_POST[$step] === ""){
            $error = TRUE;
            header("location: addrecipe.php?error=missing");
        }
        $curStep++;
        $step = "step" . $curStep;
    };
    
    if ($error === FALSE){

    $stmt = $connection->prepare("INSERT INTO recipe_names (recipe_name, recipe_score) VALUES (?, '0');");
    $stmt->bind_param("s", $name);
    $name = ucfirst(strtolower($_POST['recipe-name']));
    $stmt->execute();
    $stmt->close();
    
    $findNameSql = "SELECT recipe_id FROM recipe_names WHERE recipe_name = '$name';";
    $result = mysqli_query($connection, $findNameSql);
    $row = mysqli_fetch_assoc($result);
    $recipeId = $row["recipe_id"];

    $curIng = 1;
    $stmt = $connection->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_name, ingredient_quantity, ingredient_units) VALUES ('$recipeId', ?, ?, ?);");
    $stmt->bind_param("sds", $newName, $newQuant, $newUnit);
    $ingName = 'i' . $curIng . '-name';
    $ingQuant = 'i' . $curIng . '-quant';
    $ingUnit = 'i' . $curIng . '-unit';
    $ingOther = 'i' . $curIng . '-other';
    $newName = ucfirst(strtolower($_POST[$ingName]));
    $newQuant = $_POST[$ingQuant];
    if ($_POST[$ingUnit] === "other") {
        $newUnit = ucfirst(strtolower($_POST[$ingOther]));
    } else {
        $newUnit = $_POST[$ingUnit];
    };

    while (array_key_exists($ingName, $_POST)) {
        $stmt->execute();
        $curIng ++;
        $ingName = 'i' . $curIng . '-name';
        $ingQuant = 'i' . $curIng . '-quant';
        $ingUnit = 'i' . $curIng . '-unit';
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
    
    $curStep = 1;
    $stmt = $connection->prepare("INSERT INTO recipe_steps (recipe_id, step) VALUES ('$recipeId', ?);");
    $stmt->bind_param("s", $newStep);
    $step = 'step' . $curStep;
    $newStep = $_POST[$step];
    
    while (array_key_exists($step, $_POST)) {
        $stmt->execute();
        $curStep ++;
        $step = 'step' . $curStep;
        if (array_key_exists($step, $_POST)) {
            $newStep = $_POST[$step];
        }
    };
    $stmt->close();
    header("location: index.html");
    };
