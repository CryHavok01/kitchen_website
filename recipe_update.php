<!doctype html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<meta charset="utf-8">
<title>J&S Kitchen</title>

<style>
    #recipe-step {
        width: 100%;
        height: 150px;
    }
</style>

</head>

<body>
    
    <div class="main">
        <div class="header">
            <h1 id="kitchen-header">Josh and Shanhu's Kitchen</h1>
            <div class="how_it_works">
                <div class="works_button">
                    <button id="works_but" type="button">How it Works</button>
                </div>
                <div class="explainer">
                    <p>Updating a recipe is similar to updating an individual ingredient, with the extra complication that we don't know in advance how many ingredients or steps there are to update.  This page starts by using the Recipe ID Key which is stored in the $_GET superglobal to find the recipe's name, and setting that as the default value for a Recipe Name text input.  Next, it finds all the ingredients associated with that Recipe ID Key, and prints a new Ingredient form for each one.  It uses an incrementing currentIngredient variable to ensure that each input field is appropriately named so that it can keep track of each ingredient's information when updating the table.  It also checks the value of each ingredient's Units, and uses that to determine which button on the radio dial should be checked by default.  Next, it uses a similar process to echo and fill in the correct number of forms for all the recipe's steps.  To add new ingredients, all of the ingredient forms wrapped in an "Ingredients" div.  Using JQuery, I find the id attribute of the last element inside that div, and save it as a variable.  I then used a regular expression to find just the number inside of that id, and saved the number as the value of currentIngredient.  I then use the same process as when adding a new recipe to create additional ingredient forms, with the currentIngredient variable used to make sure that the form's names are all correctly numbered.  A similar process is used for adding additional steps.  When you're finished updating, submitting the form runs essentially the same php as when inserting a new recipe, except this time it updates only the necessary tables and rows, using the Recipe ID Key.  To finish the tour of this website, select any recipe you like and click Make this Recipe.  Don't worry about it changing my ingredient totals, I promise I won't be mad.</p>
                    </div>
                </div>
        </div>

<?php
include_once 'dbh.php';
$recipe_id = $_GET['recipe_id'];
$sql = "SELECT * FROM recipe_names WHERE recipe_id = '$recipe_id';";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

echo "<h2>" . $row['recipe_name'] . "</h2>";


if (array_key_exists('error', $_GET)){
    if ($_GET['error'] === "copy"){
        echo "<h3>A  Recipe with that name already exists!  Please use a different name, or update that Repcipe.</h3>";
    } else if ($_GET['error'] === "missing"){
        echo "<h3>You left something blank!  Make sure you fill out all fields and select Units for every ingredient</h3>";
    }
};
?>

<br>


<form id="recipe_update" action="rec_update_insert.php" method="POST">
    <br>
    <?php
    echo "<input type='hidden' name='recipe_num' value='" . $recipe_id . "'>";
    echo "<label>Recipe Name:  </label><input type='text' name='recipe_name' autocomplete='off' value='" . $row['recipe_name'] . "'><br><br>";
    $ingSql = "SELECT * FROM recipe_ingredients WHERE recipe_id = '$recipe_id';";
    $result = mysqli_query($connection, $ingSql);
    $curIng = 1;
    echo "<div id='ingredients'>";
    while ($row = mysqli_fetch_assoc($result)){
        echo "<input type='hidden' class='i" . $curIng . "-id' name='i" . $curIng . "-id' value='" . $row['id'] . "'>";
        echo "<div id='ing" . $curIng . "-form'><label class='ing-label'>Ingredient " . $curIng . ":  </label><input type='text' class='i" . $curIng . "-name' name='i" . $curIng . "-name' autocomplete='off' value='" . $row['ingredient_name'] . "'><br>";
        echo "<label>Quantity:  </label><input type='number' step='0.01' class='i" . $curIng . "-quant' name='i" . $curIng . "-quant' value='" . ($row['ingredient_quantity'] + 0) . "'><br>";
        echo "<label>Units:  </label>";
        if ($row['ingredient_units'] === 'Teaspoon(s)'){
            echo "<input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Teaspoon(s)' checked='checked'>Teaspoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Tablespoon(s)'>Tablespoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Ounce(s)'>Ounce(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Cup(s)'>Cup(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='other'>Other
            <input type='text' class='i" . $curIng . "-other' name='i" . $curIng . "-other' autocomplete='off' value=''><br><br></div>";
        } else if ($row['ingredient_units'] === 'Tablespoon(s)'){
            echo "<input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Teaspoon(s)'>Teaspoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Tablespoon(s)' checked='checked'>Tablespoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Ounce(s)'>Ounce(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Cup(s)'>Cup(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='other'>Other
            <input type='text' class='i" . $curIng . "-other' name='i" . $curIng . "-other' autocomplete='off' value=''><br><br></div>";
        } else if ($row['ingredient_units'] === 'Ounce(s)'){
            echo "<input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Teaspoon(s)'>Teaspoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Tablespoon(s)'>Tablespoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Ounce(s)' checked='checked'>Ounce(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Cup(s)'>Cup(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='other'>Other
            <input type='text' class='i" . $curIng . "-other' name='i" . $curIng . "-other' autocomplete='off' value=''><br><br></div>";
        } else if ($row['ingredient_units'] === 'Cup(s)'){
            echo "<input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Teaspoon(s)'>Teaspoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Tablespoon(s)'>Tablespoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Ounce(s)'>Ounce(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Cup(s)' checked='checked'>Cup(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='other'>Other
            <input type='text' class='i" . $curIng . "-other' name='i" . $curIng . "-other' autocomplete='off' value=''><br><br></div>";
        } else {
            echo "<input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Teaspoon(s)'>Teaspoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Tablespoon(s)'>Tablespoon(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Ounce(s)'>Ounce(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='Cup(s)'>Cup(s)<br>
            <input type='radio' class='i" . $curIng . "-units' name='i" . $curIng . "-units' value='other' checked='checked'>Other
            <input type='text' class='i" . $curIng . "-other' name='i" . $curIng . "-other' autocomplete='off' value='" . $row['ingredient_units'] . "'><br><br></div>";
        };
    $curIng++;
    };
    
    echo "</div>";
    echo "<div id='end-ing'></div>";
    echo "<button type='button' id='new-ingredient'>New Ingredient</button><br><br>";
    
    $stepSql = "SELECT * FROM recipe_steps WHERE recipe_id = '$recipe_id';";
    $result = mysqli_query($connection, $stepSql);
    $curStep = 1;
    echo "<div id='steps'>";
        while ($row = mysqli_fetch_assoc($result)){
            echo "<input type='hidden' name='step" . $curStep . "-id' value='" . $row['id'] . "'>";
            echo "<div id='step" . $curStep . "-form'><label class='step-label'>Step " . $curStep . ":  </label>";
            echo "<textarea id='recipe-step' class='step" . $curStep . "' name='step" . $curStep . "' autocomplete='off'>" . $row['step'] . "</textarea><br><br></div>";
            $curStep++;
        };
    echo "</div>";
    echo "<div id='end-step'></div>";
    echo "<button type='button' id='new-step'>New Step</button><br><br>";
    
    ?>
    
    <br>
    <button type="submit" name="submit">Update Recipe</button>
    <button type="button" id="cancel_update">Cancel</button>
</form>
<div id="warning">
    <h3>Warning!</h3>
    <p>Are you SURE you want to delete this item?</p>
    <form id="ing_delete" action="ingredient_delete.php" method="POST">
    <br>
    <?php
    echo "<input type='hidden' name='recipe_id' value='" . $recipe_id . "'>";
    ?>
    <button type="submit" id="confirm_delete">Delete for Real!</button>

    <button type="button" id="cancel_delete">Cancel</button>
    </form>
</div>

<br><br>

</div>
<div class="links">
    <button type="button" id="nav_but">Navigation</button>
    <div class="nav_bar">
        <button type="button" id="home" onclick="window.location.href='index.php';">Home</button>
        <button type="button" id="check-spices" onclick="window.location.href='checkspice.php';">Check Spices</button>
        <button type="button" id="add-spice" onclick="window.location.href='addspice.php';">Add Spice</button>
        <button type="button" id="check-recipe" onclick="window.location.href='checkrecipe.php';">Look up Recipes</button>
        <button type="button" id="add-recipe" onclick="window.location.href='addrecipe.php';">Add new Recipe</button>
    </div>
</div>    
    
<script src="jquery-3.5.1.min.js"></script>
<script>

    //How It Works Section
            
    let worksOn = false;
    let expHeight = 0;
    let expWidth = 0;
            
    $("#works_but").on("click", () => {
        if (worksOn) {
            $(".explainer").animate({
                height: "0",
                width: "0",
                marginLeft: "100%"
            }, () => {
                $(".explainer").css("display", "none")
            });
            $("#works_but").html("How it Works")
            worksOn = false;
        } else {
            $(".explainer").css("display", "block")
            if (!expHeight && !expWidth) {
                expHeight = $(".explainer").height();
                expWidth = $(".explainer").width();
            }
            $(".explainer").css("height", "0");
            $(".explainer").css("width", "0");
            $(".explainer").css("margin-left", "100%");
            $(".explainer").animate({
                height: expHeight, 
                width: expWidth,
                marginLeft: "0"
            })
            $("#works_but").html("Hide")
            worksOn = true;
        }
    })

//navigation bar
    let navOn = false;
    let height = 0;
    $("#nav_but").on("click", () => {
        if (navOn) {
            $(".nav_bar").animate({height: "0"}, () => {
                $(".nav_bar").css("display", "none")
            })
            $("#nav_but").html("Navigation")
            navOn = false;
        } else {
            $(".nav_bar").css("display", "block")
            if (!height) {
                height = $(".nav_bar").height();
            }
            $(".nav_bar").css("height", "0")
            $(".nav_bar").animate({height: height})
            $("#nav_but").html("Hide")
            navOn = true;
        }
    })

//errors, buttons
    $('#warning').hide();
    $('#ing_update').hide();
    $('#update').on("click", function(){
        $('#ing_update').show();
        $('#update').hide();
    });
    $('#delete').on('click', function(){
        $('#warning').show();
        $('#delete').hide();
    });
    $('#cancel_delete').on('click', function(){
        $('#warning').hide();
        $('#delete').show();
    });
    $('#cancel_update').on('click', function(){
        $('#ing_update').hide();
        $('#update').show();
    });

//new ingredients, steps    
    var lastIng = $("#ingredients").children().last().attr("id");
    var curIng = Number(lastIng.match(/\d+/));
    var lastStep =$("#steps").children().last().attr("id");
    var curStep = Number(lastStep.match(/\d+/));
    
    $("#new-ingredient").on('click', function(){
        curIng++;
        var $cloneIng = $("#ing1-form").clone();
        $cloneIng.find(".ing-label").text("Ingredient " + curIng + " Name:  ");
        $cloneIng.find(".i1-name").val("");
        $cloneIng.find(".i1-name").attr("name", "i" + curIng + "-name");
        $cloneIng.find(".i1-quant").val("");
        $cloneIng.find(".i1-quant").attr("name", "i" + curIng + "-quant");
        $cloneIng.find(".i1-units").attr("name", "i" + curIng + "-units");
        $cloneIng.find(".i1-other").val("");
        $cloneIng.find(".i1-other").attr("name", "i" + curIng + "-other");
        $cloneIng.appendTo("#end-ing");
    });
    
    $("#new-step").on('click', function(){
        curStep++;
        var $cloneStep = $("#step1-form").clone();
        $cloneStep.find(".step-label").text("Step " + curStep + ":  ");
        $cloneStep.find(".step1").attr("name", "step" + curStep);
        $cloneStep.find(".step1").val("")
        $cloneStep.appendTo("#end-step");
    })
    
</script>
</body>
</html>
